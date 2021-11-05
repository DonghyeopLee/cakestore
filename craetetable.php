<?php
require_once("connection.php");

if($mysqli === false){
    die("ERROR: could not connect. ". $mysqli ->connect_error  );
}
    else{
        $sql = "CREATE TABLE cake_category(
                categoryID int AUTO_INCREMENT not null primary key,
                category_title varchar(60) not null,
                cay_desc varchar(60) not null);

                CREATE TABLE cake_item(
                itemID int AUTO_INCREMENT not null primary key,
                categoryID int not null,
                item_name varchar(60) not null,
                item_price varchar(60) not null, 
                item_desc varchar(60) not null,          
                cake_photo varchar(100) not null,);

                CREATE TABLE cake_orders(
                orderID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                order_date DATETIME,
                order_name VARCHAR (100),
                order_addresVARCHAR (255),
                order_city VARCHAR (50),
                order_state CHAR(2),
                order_zip VARCHAR(10),
                order_tel VARCHAR(25),
                order_email VARCHAR(100),
                item_total FLOAT(6,2),
                shipping_total FLOAT(6,2),
                authorization VARCHAR (50),
                status EN('processed', 'pending');

                CREATE TABLE cake_order_items(
                ID int AUTO_INCREMENT not null primary key,
                varchar(60) not null,
                varchar(60) not null,                
                varchar(100) not null,);
                ";
        $result = $mysqli -> query($sql);
        if($result){
            echo "Table is successfully created";
        }else{
            echo "Table has somrthing wrong";
        }        
    }


CREATE TABLE cake_(
                ID int AUTO_INCREMENT not null primary key,
                varchar(60) not null,
                varchar(60) not null,                
                varchar(100) not null,);


$mysqli -> close();



?>