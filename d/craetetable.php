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
                item_desc varchar(500) not null,          
                cake_photo varchar(100) not null);

                CREATE TABLE cake_orders(
                orderID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                order_date DATETIME,
                order_name VARCHAR (100),
                order_addres VARCHAR (255),
                order_city VARCHAR (50),
                order_state CHAR(2),
                order_zip VARCHAR(10),
                order_tel VARCHAR(25),
                order_email VARCHAR(100),
                item_total FLOAT(6,2),
                shipping_total FLOAT(6,2),
                authorization VARCHAR (50),
                status ENUM('processed', 'pending'));

                CREATE TABLE cake_orders_items(
                ID int AUTO_INCREMENT not null primary key,
                orderID int,
                sel_item_qty smallint,                
                sel_item_size varchar(100) ,
                sel_item_colour varchar(60),
                sel_item_price float(6,2));

                CREATE TABLE cake_shopertrack(
                trackID int AUTO_INCREMENT not null primary key,
                session_id varchar(60) ,
                sel_itemID varchar(60) ,
                sel_item_qty smallint,                
                sel_item_size varchar(100) ,                
                date_added datetime);

                CREATE TABLE cake_size(
                ID int AUTO_INCREMENT not null primary key,
                itemID varchar(60) ,
                item_size varchar(60));

                CREATE TABLE forum_posts (
                `post_id` int(11) NOT NULL AUTO_INCREMENT,
                `topic_id` int(11) NOT NULL,
                `post_text` text,
                `post_create_time` datetime DEFAULT NULL,
                `post_owner` varchar(150) DEFAULT NULL,
                PRIMARY KEY (`post_id`));

                CREATE TABLE forum_topics (
                `topic_id` int(11) NOT NULL AUTO_INCREMENT,
                `topic_title` varchar(150) DEFAULT NULL,
                `topic_create_time` datetime DEFAULT NULL,
                `topic_owner` varchar(150) DEFAULT NULL,
                PRIMARY KEY (`topic_id`));


                ";
        $result = $mysqli -> query($sql);
        if($result){
            echo "Table is successfully created";
        }else{
            echo "Table has somrthing wrong";
        }        
    }




$mysqli -> close();



?>