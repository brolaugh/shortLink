<?php
class Link{
  private $mysqli;
  private $long_link;
  private $pref_l;
  public $errors;
  /**
  * Public classes: getLongLink(), IsShortLinkFree(), createLink()
  */
  function __construct(){
    $this->freeSpot = false;
    $this->insertLinkEnabled = false;
    require_once("config/config.php");
    $this->mysqli = makeMysqli();
  }
  public function getLongLink($shortLink){
    /**
    * Send the short link with the base URL stripped from the string
    * If the short link exists in the database the long link is returned
    * if the short link doesn't exist in the database false is returned
    */

    if(!preg_match("/[a-zA-Z0-9]+/", $shortLink)){
      array_push($this->errors, "Short link didn't match the parameters");
    }
    $stmt = $this->mysqli->prepare("SELECT long_link FROM links WHERE short_link = ?");
    $stmt->bind_param('s', $shortLink);
    $stmt->execute();
    $stmt->bind_result($longLink);
    if ($stmt->fetch()){
      $stmt->close();
      return $longLink;
    }
    else{
      array_push($this->errors, "getLongLink(): short link doesn't exist");
      return false;
    }
  }
  public function IsShortLinkAvailable($shortLink){
    /**
    *checks if the short link is already in use
    * if available returns true
    * if not available returns false
    */
    $stmt = $this->mysqli->prepare("SELECT short_link FROM links WHERE short_link = ?");
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
  public function createLink($rawlong_link, $rawPref_l){
    /**
    * Create a short link by sending a long link and either an empty or a filled string
    * if the string is empty the next shortlink string available will be used
    * if
    **/
    $this->long_link = $rawlong_link;
    $this->pref_l = $rawPref_l;
    if(strlen($this->pref_l) != 0){
      if(!preg_match("/[a-zA-Z0-9]+/", $this->pref_l)){
        array_push($this->errors, "Preffered link didn't match parameters");
      }
      else{
        if($this->isLongLinkAvailable($this->rawlong_link)){
          $this->insertLink();
        }
        else{
          array_push($this->errors, "Link was already in use");
          return false;
        }
      }
    }
    else{
      if($shortLink = $this->isLongLinkUsed($this->long_link)){
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
    $stmt = $this->mysqli->prepare("SELECT short_link FROM links WHERE custom = 0 ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $stmt->bind_result($lastLink);
    if($stmt->fetch()){
      return $lastLink;
    }
    else{
      array_push($this->errors, "Was unable to get last link");
      return false;
    }
  }

  private function isLongLinkUsed($longLink){
    $stmt = $this->mysqli->prepare("SELECT short_link FROM links WHERE long_link = ? AND custom = 0");
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
  private function insertLink(){
    $stmt = $this->mysqli->prepare("INSERT INTO links(short_link, long_link, custom) VALUES(?,?,0);");

    $stmt->bind_param('ss', $this->new_l, $this->long_link);
    if($stmt->execute()){
      $stmt->close();
      return true;
    }
    else{
      $stmt->close();
      array_push($this->errors, "short link is already in use");
      return false;
    }
  }
}
?>
