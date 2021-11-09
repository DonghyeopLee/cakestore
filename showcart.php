<?php
  session_start();
//connect to database
require_once("connection.php");
$display_block = "<h1>Your Shopping Cart</h1>";

 //check for cart items based on user session id

 
 $get_cart_sql = "SELECT ct.trackID, ci.item_name, ci.item_price,
   ct.sel_item_qty, ct.sel_item_size FROM
   cake_shopertrack AS ct LEFT JOIN cake_item AS ci ON
   ci.itemID = ct.sel_itemID WHERE session_id =
   '".$_COOKIE['PHPSESSID']."'";
     $get_cart_res = mysqli_query($mysqli, $get_cart_sql)
   or die(mysqli_error($mysqli));
     if (mysqli_num_rows($get_cart_res) < 1) {
       //print message
    $display_block .= "<p>You have no items in your cart.
    Please <a href=\"seecakes.php\">continue to shop</a>!</p>";
  } else {
       //get info and build cart display
    $display_block .= <<<END_OF_TEXT
        <div class="content1">
        <table>
        <tr>
        <th>Title</th>
        <th>Size</th>        
        <th>Price</th>
        <th>Qty</th>
        <th>Total Price</th>
        <th>Action</th>
        </tr>
     END_OF_TEXT;

    while ($cart_info = mysqli_fetch_array($get_cart_res)) {
        $trackID = $cart_info['trackID'];
    $item_title = stripslashes($cart_info['item_name']);
    $item_price = $cart_info['item_price'];
    $item_qty = $cart_info['sel_item_qty'];    
    $item_size = $cart_info['sel_item_size'];
    $total_price = sprintf("%.02f", $item_price * $item_qty);
    $display_block .= <<<END_OF_TEXT
        <tr>
        <td>$item_title <br></td>
        <td>$item_size <br></td>        
        <td>\$ $item_price <br></td>
        <td>$item_qty <br></td>
        <td>\$ $total_price</td>
        <td><a href="removefromcart.php?trackID=$trackID">remove</a></td>
        </tr>
     END_OF_TEXT;
    }
       $display_block .= "</table>";
       $display_block .= "</div>";
 }
    //free result
    mysqli_free_result($get_cart_res);

    
//close connection to MySQL
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="../ass/Style.css">
</head>
<body>
    <div class="container">
        <div class="logo">    
            <a href="../ass/index.html" ><img alt="Photo" src="../ass/images/cakehouse.jfif"></a>
        </div>    
        <div class="nav">
            <ul>
                <li><a href="../ass/index.html">Home</a></li>
                <li><a href="../ass/seecakes.php">Cakes</a></li>
                <li><a href="../ass/about.html">About</a></li>
                <li><a href="../ass/topiclist.php">Review</a></li>
                <li><a href="../ass/contactUs.html">Contact Us</a> </li>
            </ul>
        </div>
        <h1>cart</h1>
        
        
         <?php echo $display_block; ?>
        

    </div>

    

</body>  
<footer><p><a href="https://www.instagram.com/"><img alt="Photo" src="../ass/images/instagram_small.png"></a><a href="https://www.facebook.com/"><img alt="Photo" src="../ass/images/facebook_small.png"></a></p> <p>Privacy Policy: We collect and utilize the information that you provide to us voluntarily.</p><p>CopyRight Ⓒ</p></footer>
  
</html>
