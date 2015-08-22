<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
  //$long_url = $_POST['long_url'];
  //$pref_l = $_POST['pref_url'];
  require_once("classes/link.class.php");
  $link = new Link();
  $long_url = "https://www.youtube.com/watch?v=h4cLFyw-k88";
  $pref_l ="";
  $new_l = $link->createLink($long_url, $pref_l);
  echo "http://l.brolaugh.com/".$new_l;
  var_dump($new_l);
 ?>
