<?php


$mysqli = new mysqli("localhost","root","","cakeshop" );
if($mysqli === false){
    die("ERROR: could not connect. ". $mysqli ->connect_error  );
}

?>