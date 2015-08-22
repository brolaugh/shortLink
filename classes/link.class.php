<?php
class Link{
  private $mysqli;
  private $long_url;
  private $pref_l;
  private $last_l;
  private $new_l;
  private $freeSpot;

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

    /*if(!preg_match("^((http[s]?|ftp):\/)?\/?([^:\/\s]+)((\/\w+)*\/)([\w\-\.]+[^#?\s]+)(.*)?(#[\w\-]+)?$", $this->longLink)){
    header("Location:error.php?e=Original URL didn't fit");
    exit();
  }*/


  require_once("classes/genstring.class.php");

  if(strlen($this->pref_l) != 0){
    if(!preg_match("/[a-zA-Z0-9]+/", $this->pref_l)){
      header("Location:error.php?e=Preffered link didn't match parameters");
      exit();
    }
  }
  else{
    /*
    check last rand link and generate new link
    if link already is present generate new link

    */
    $stmt = $this->mysqli->prepare("SELECT short_url FROM links WHERE custom = 0 LIMIT 1");
    $stmt->execute();
    $stmt->bind_result($last_l);
    $stmt->fetch();
    echo $this->last_l;
    $this->last_l = $last_l;
    $stmt->close();

    require_once("classes/genstring.class.php");
    while(!$this->freeSpot){
      $genString = new genString($this->last_l);
      $genString->makeNewString();
      $this->new_l = $genString->getNewString();

      $stmt = $this->mysqli->prepare("SELECT short_url FROM links WHERE short_url = ?");
      $stmt->bind_param('s', $this->new_l);
      $stmt->execute();
      $stmt->bind_result($temp);
      echo "Test123";
      if($stmt->fetch()) {
        $this->freeSpot = true;
      }
      else{
        $stmt->bind_result($this->last_l);
        $stmt->execute();
        $stmt->close();
      }
    }
    $this->insertLink();
    /**/
    return $this->new_l;
  }
}

//This shit isn't working as it should.
private function insertLink(){
  $stmt = $this->mysqli->prepare("INSERT INTO links(short_url, long_url, custom) VALUES(?,?,?);");
  echo "<pre>";

  var_dump($this->new_l);
  var_dump($this->long_url);
  $temp = 0;
  $stmt->bind_param('ssi', $this->new_l, $this->long_url, $temp);
  $stmt->execute();
  $stmt->close();
}
}
?>
