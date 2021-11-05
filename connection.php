<?php


$mysqli = new mysqli("localhost","root","","" );
if($mysqli === false){
    die("ERROR: could not connect. ". $mysqli ->connect_error  );
}

?>