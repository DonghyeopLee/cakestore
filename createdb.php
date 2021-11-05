<?php
$mysqli = new mysqli("localhost","root","");

if($mysqli === false){
    die("ERROR: could not connect. ". $mysqli ->connect_error  );
}
    else{
        $sql = "CREATE DATABASE cakeShop";
        $result = $mysqli ->query($sql);
        if($result){
            echo "Database is successfully created";
        }
        else{
            echo "Databae has spmething wrong";
        }
    }

$mysqli -> close();
?>    