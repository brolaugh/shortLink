<?php
function makeMysqli(){
  define("SQL_UN", "");
  define("SQL_PW", "");
  define("SQL_DB", "");
  define("SQL_AD", "");

  $mysqli = new mysqli(SQL_AD, SQL_UN, SQL_PW, SQL_DB);
  $mysqli->set_charset("utf8");
  if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    }
    return $mysqli;
}
