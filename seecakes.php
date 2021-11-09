<?php
//connect to database
require_once("connection.php");

$display_block = "<h1>cakes Categories</h1>
<p>Select a category to see its items.</p>";

//show categories first
$get_cats_sql = "SELECT categoryID, category_title, cay_desc FROM cake_category ORDER BY category_title";

$get_cats_res =  mysqli_query($mysqli, $get_cats_sql)
                 or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_cats_res) < 1) {$display_block = "<p><em>Sorry, no categories to browse.</em></p>";

} 
else {
    while ($cats = mysqli_fetch_array($get_cats_res)) {
        $categoryID  = $cats['categoryID'];
        $cat_title = strtoupper(stripslashes($cats['category_title']));
        $cat_desc = stripslashes($cats['cay_desc']);
        $display_block .= "<p><strong><a href=\"".$_SERVER['PHP_SELF']."?categoryID=".$categoryID."\">".$cat_title."</a></strong><br/>".$cat_desc."</p>";
            if (isset($_GET['categoryID']) && ($_GET['categoryID'] == $categoryID)) {
            //create safe value for use
            $safe_cat_id = mysqli_real_escape_string($mysqli,$_GET['categoryID']);
            //get items
            $get_items_sql = "SELECT itemID, item_name, item_price FROM cake_item WHERE categoryID = '".$categoryID."' ORDER BY item_name";
            $get_items_res = mysqli_query($mysqli, $get_items_sql)or die(mysqli_error($mysqli));
                if (mysqli_num_rows($get_items_res) < 1) {
                $display_block = "<p><em>Sorry, no items in thiscategory.</em></p>";
                } 
                else {
                $display_block .= "<ul>";
                while ($items = mysqli_fetch_array($get_items_res)) {$itemID  = $items['itemID'];
                $item_name = stripslashes($items['item_name']);
                $item_price = $items['item_price'];
                $display_block .= "<li><a href=\"showcakes.php?itemID=".$itemID."\">".$item_name."</a>(\$".$item_price.")</li></br>";
            }
            $display_block .= "</ul>";
        }
        //free results
            
        mysqli_free_result($get_items_res);

        }   
        }
    }

    //free results
    mysqli_free_result($get_cats_res);

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
            <li><a href="../ass/topiclist.php">Review</a> </li>
            <li><a href="../ass/contactUs.html">Contact Us</a> </li>
        </ul>
    </div>
    <h1>cake house</h1>
    <?php echo $display_block; ?>


</div>    
    

</body>  
<footer><p><a href="https://www.instagram.com/"><img alt="Photo" src="../ass/images/instagram_small.png"></a><a href="https://www.facebook.com/"><img alt="Photo" src="../ass/images/facebook_small.png"></a></p> <p>Privacy Policy: We collect and utilize the information that you provide to us voluntarily.</p><p>CopyRight Ⓒ</p></footer>
  
</html>