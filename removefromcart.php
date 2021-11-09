<?php
  session_start();
  if (isset($_GET['trackID'])) {
    //connect to database
    require_once("connection.php");
//create safe values for use
$safe_id = mysqli_real_escape_string($mysqli, $_GET['trackID']);

$delete_item_sql = "DELETE FROM cake_shopertrack WHERE trackID = '".$safe_id."' and session_id ='".$_COOKIE['PHPSESSID']."' ";
     $delete_item_res = mysqli_query($mysqli, $delete_item_sql)
or die(mysqli_error($mysqli));
     //close connection to MySQL
     mysqli_close($mysqli);
     //redirect to showcart page
     header("Location: showcart.php");
     exit;
  } else {
         //send them somewhere else
     header("Location: seecakes.php");
     exit;
  }
  ?>