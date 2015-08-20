<?php
  class Link{
    private $mysqli;
    private $long_url;
    private $pref_l;

    function __construct($rawLong_url, $rawPref_l){
      $this->long_url = $rawLong_url;
      $this->pref_l = $rawPref_l;
      if(!preg_match("[az-AZ0-9]*", $this->pref_l)){
        exit();
      }
    /*  if(!preg_match("")){

    }*/
      require_once("../config/config.php");

      $this->mysqli = $mysqli;

    }
    public function getLongLink($shortLink){

      str_replace("http://www.l.brolaugh.com/", "", $shortLink);
      if(!preg_match("[az-AZ0-9]*", $shortLink)){
        exit();
      }

      $stmt = $this->mysqli->prepare("SELECT long_url FROM links WHERE short_url = ?");
      $stmt->bind_param($shortLink);
      $stmt->execute();
      $stmt->bind_result($longLink);
      $stmt->fetch()
      return $longLink;

    }
    public function createLink(){
      $stmt = $this->mysqli->prepare("SELECT ")


      require_once("../classes/genstring.class.php");

      if(strlen($this->pref_l) != 0){
        $subURL = $this->pref_l;
      }
      else{
        $subURL = genRandStr(7);
      }

      $stmt = $this->mysqli->prepare("INSERT INTO links(long_url, short_url) values(?,?)");

      $stmt->bind_param($this->long_url, $this->short_url);
      $stmt->execute();

    }
}



 ?>
