<?php
  //connect to database
  require_once("connection.php");

  $display_block = "<h1>My Store - Item Detail</h1>";
  //create safe values for use
  $safe_item_id = mysqli_real_escape_string($mysqli, $_GET['itemID']);
  //validate item
   $get_item_sql = "SELECT c.categoryID as categoryID , c.category_title, ci.item_name, ci.item_price, ci.item_desc, ci.cake_photo FROM cake_item
  AS ci LEFT JOIN cake_category AS c on c.categoryID = ci.categoryID
  WHERE ci.itemID = '".$safe_item_id."'";
   $get_item_res = mysqli_query($mysqli, $get_item_sql)
  or die(mysqli_error($mysqli));
   if (mysqli_num_rows($get_item_res) < 1) {
           //invalid item
         $display_block .= "<p><em>Invalid item selection.</em></p>";
 } else {
           //valid item, get info
         while ($item_info = mysqli_fetch_array($get_item_res)) {
      $categoryID = $item_info['categoryID'];
    $cat_title = strtoupper(stripslashes($item_info['category_title']));
    $item_name = stripslashes($item_info['item_name']);
    $item_price = $item_info['item_price'];
    $item_desc = stripslashes($item_info['item_desc']);
    $cake_photo = $item_info['cake_photo'];
     }
      //make breadcrumb trail & display of item
      $display_block .= <<<END_OF_TEXT
      
      <p><em>You are viewing: </em><br/>
      <strong><a href="seecakes.php?categoryID=$categoryID">$cat_title</a> &gt; $item_name</strong></p>
      <div class="image1" ><img src="../ass/images/$cake_photo" alt="$item_name" /></div>
      <div class="content1" >
      <p><strong>Description:</strong><br/>$item_desc</p>
      <p><strong>Price: </strong> \$$item_price</p>
      <form method="post" action="addtocart.php">
   END_OF_TEXT;
      //free result
      mysqli_free_result($get_item_res);

    //get sizes
    $get_sizes_sql = "SELECT item_size FROM cake_size WHERE itemID = ".$safe_item_id." ORDER BY item_size";
    $get_sizes_res = mysqli_query($mysqli, $get_sizes_sql)
or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_sizes_res) > 0) {
    $display_block .= "<p><label for=\"sel_item_size\">
    Available Size:</label>
    <select id=\"sel_item_size\" name=\"sel_item_size\">";
    while ($sizes = mysqli_fetch_array($get_sizes_res)) {
     $item_size = $sizes['item_size'];
    $display_block .= "<option value=\"".$item_size ."\">".$item_size ."</option>";        
    }
    $display_block .= "</select></p>";  
    }
    //free result
    mysqli_free_result($get_sizes_res);
    $display_block .= "
        <p><label for=\"sel_item_qty\">Select Quanti
    </label>
        <select id=\"sel_item_qty\" name=\"sel_item_qty\">";
        for($i=1; $i<11; $i++) {
        $display_block .= "<option value=\"".$i."\">".$i."</option>";
        }
        $display_block .= <<<END_OF_TEXT
       </select></p>
       <input type="hidden" name="sel_itemID"
       value="$_GET[itemID]" />
       <button type="submit" name="submit" value="submit">
       Add to Cart</button>
       </form>
       </div>
             
     END_OF_TEXT;
 }
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
    
    <?php echo $display_block; ?>



</div>

</body>  
<footer><p><a href="https://www.instagram.com/"><img alt="Photo" src="../ass/images/instagram_small.png"></a><a href="https://www.facebook.com/"><img alt="Photo" src="../ass/images/facebook_small.png"></a></p> <p>Privacy Policy: We collect and utilize the information that you provide to us voluntarily.</p><p>CopyRight Ⓒ</p></footer>
  
</html>
