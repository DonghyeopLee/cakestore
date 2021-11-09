<?php
  session_start();
  if (isset($_POST['sel_itemID'])) {
    //connect to database
    $mysqli = mysqli_connect("localhost", "root", "", "cakeshop");
//create safe values for use
    $safe_sel_itemID = mysqli_real_escape_string($mysqli,$_POST['sel_itemID']);
     $safe_sel_item_qty = mysqli_real_escape_string($mysqli,$_POST['sel_item_qty']);
     $safe_sel_item_size = mysqli_real_escape_string($mysqli,$_POST['sel_item_size']);


     //validate item and get title and price1
     $get_iteminfo_sql = "SELECT item_name FROM cake_item WHERE ItemID = '".$safe_sel_itemID."'";
     $get_iteminfo_res = mysqli_query($mysqli, $get_iteminfo_sql)or die(mysqli_error($mysqli));

     if (mysqli_num_rows($get_iteminfo_res) < 1) {
    //free result2
    mysqli_free_result($get_iteminfo_res);
        
    //close connection to MySQL
    mysqli_close($mysqli);
        
    //invalid id, send away
    echo "error";
    exit;     
    } else {
        
    //get info
while ($item_info = mysqli_fetch_array($get_iteminfo_res)) {$item_name =  stripslashes($item_info['item_name']);
}

//free result
mysqli_free_result($get_iteminfo_res);

//add info to cart table
$addtocart_sql = "INSERT INTO cake_shopertrack
(session_id, sel_itemID, sel_item_qty, sel_item_size, date_added)
VALUES ('".$_COOKIE['PHPSESSID']."',
'".$safe_sel_itemID."',
'".$safe_sel_item_qty."',
'".$safe_sel_item_size."', now())";
$addtocart_res = mysqli_query($mysqli, $addtocart_sql)
or die(mysqli_error($mysqli));

//close connection to MySQL
mysqli_close($mysqli);

//redirect to showcart page
header("Location: showcart.php");
exit;
     }

 } else {
    //send them somewhere else
    echo "error";
    exit;
 }
 ?>