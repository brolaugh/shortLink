<?php
  ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(-1);
  error_reporting(E_ALL & ~E_NOTICE);

  $shortLink = $_GET['l'];
  //var_dump( $shortLink );
  require_once("classes/link.class.php");
  $link = new Link();
  $longLink = $link->getLongLink($shortLink);
  if($longLink == false){
    //echo $longLink;
    var_dump($longLink);
    echo "Link doesn't exist";
  }
  else{
    header("Location:".$longLink);
  }
 ?>
