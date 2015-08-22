<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

  require_once("classes/link.class.php");
  $link = new Link();
  $rawLong_url = "https://www.facebook.com/groups/Swerigs/493333117501719/?notif_t=group_comment_reply";
  $rawPref_l = "";

  $newLink = $link->createLink($rawLong_url, $rawPref_l);
  echo "http:l.brolaugh.com/".$newLink;
 ?>
