<?php
class Link{
  private $mysqli;
  private $long_url;
  private $pref_l;

  function __construct(){
    $this->freeSpot = false;
    require_once("config/config.php");
    $this->mysqli = makeMysqli();
  }
  public function getLongLink($shortLink){
    if(!preg_match("/[a-zA-Z0-9]+/", $shortLink)){
      echo "didn't match paramenters";
      exit();
    }
    $stmt = $this->mysqli->prepare("SELECT long_url FROM links WHERE short_url = ?");
    $stmt->bind_param('s', $shortLink);
    $stmt->execute();
    $stmt->bind_result($longLink);
    if ($stmt->fetch()){
      $stmt->close();
      return $longLink;
    }
    else{
      return false;
    }
  }

  public function createLink($rawLong_url, $rawPref_l){
    $this->long_url = $rawLong_url;
    $this->pref_l = $rawPref_l;
  if(strlen($this->pref_l) != 0){
    if(!preg_match("/[a-zA-Z0-9]+/", $this->pref_l)){
      header("Location:error.php?e=Preffered link didn't match parameters");
      exit();
    }
    else{
      if($this->IsShortLinkFree($this->rawLong_url)){
        $this->insertLink();
      }
      else{
        header("Location:error.php?e=Link was already in use.");
        exit();
      }
    }
  }
  else{
    if($shortLink = $this->isLongLinkUsed($this->long_url)){
      return $shortLink;
    }
    else{
      require_once("classes/genstring.class.php");
      /*
      check last rand link and generate new link
      if link already is present generate new link
      */
      $this->last_l = $this->getLastLink();
      $genString = new GenString($this->last_l);
      $this->new_l = $genString->genStr();
      while(!$this->IsShortLinkFree($this->new_l)){
        $genString->reGen();
      }
      if($this->insertLink()){
        return $this->new_l;
      }
      else{
        return false;
      }
    }

  }
}
private function getLastLink(){
  $stmt = $this->mysqli->prepare("SELECT short_url FROM links WHERE custom = 0 ORDER BY id DESC LIMIT 1");
  $stmt->execute();
  $stmt->bind_result($lastLink);
  if($stmt->fetch()){
    return $lastLink;
  }
  else{
    return false;
  }
}
private function IsShortLinkFree($shortLink){
  $stmt = $this->mysqli->prepare("SELECT short_url FROM links WHERE short_url = ?");
  $stmt->bind_param('s', $shortLink);
  $stmt->execute();
  $stmt->bind_result($temp);
  if($stmt->fetch()){
    return false;
  }
  else{
    return true;
  }
}
private function isLongLinkUsed($longLink){
  $stmt = $this->mysqli->prepare("SELECT short_url FROM links WHERE long_url = ? AND custom = 0");
  $stmt->bind_param('s', $longLink);
  $stmt->execute();
  $stmt->bind_result($shortLink);
  if($stmt->fetch()){
    return $shortLink;
  }
  else{
    return false;
  }
}
//This shit isn't working as it should.
private function insertLink(){
  $stmt = $this->mysqli->prepare("INSERT INTO links(short_url, long_url, custom) VALUES(?,?,?);");
  echo "<pre>";
  echo $this->mysqli->error;

  $temp = 0;
  $stmt->bind_param('ssi', $this->new_l, $this->long_url, $temp);
  if($stmt->execute()){
    $stmt->close();
    return true;
  }
  else{
    $stmt->close();
    return false;
  }
}
}
?>
