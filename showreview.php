<?php
   require_once("connection.php");
   //check for required info from the query string
   if (!isset($_GET['topic_id'])) {
    header("Location: topiclist.php");
exit;
   }
   //create safe values for use
  $safe_topic_id = mysqli_real_escape_string($mysqli, $_GET['topic_id']);
  //verify the topic exists
  $verify_topic_sql = "SELECT topic_title FROM forum_topics
                       WHERE topic_id = '".$safe_topic_id."'";
  $verify_topic_res =  mysqli_query($mysqli, $verify_topic_sql) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($verify_topic_res) < 1) {
             //this topic does not exista
         $display_block = "<p><em>You have selected an invalid topic.<br/> Please <a href=\"topiclist.php\">try again</a>.</em></p>" ;
  } 
  else {
             //get the topic title
         while ($topic_info = mysqli_fetch_array($verify_topic_res)) {
        $topic_title = stripslashes($topic_info['topic_title']);
     }
        //gather the posts
        $get_posts_sql = "SELECT post_id, post_text, DATE_FORMAT(post_create_time, '%b %e %Y<br/>%r') AS fmt_post_create_time, post_owner  FROM forum_posts
        WHERE topic_id = '".$safe_topic_id."' ORDER BY post_create_time ASC";
        $get_posts_res = mysqli_query($mysqli, $get_posts_sql) or die(mysqli_error($mysqli));
    //create the display string
    $display_block = <<<END_OF_TEXT
        <p>Showing posts for the <strong>$topic_title</strong> topic:</p>
        <table>
        <tr>
        <th>User</th>
        <th>Review</th>
        </tr>
    END_OF_TEXT;

    while ($posts_info = mysqli_fetch_array ($get_posts_res)) {
        $post_id = $posts_info['post_id'];
        $post_text = nl2br(stripslashes($posts_info ['post_text']));
        $post_create_time = $posts_info ['fmt_post_create_time'];
        $post_owner = stripslashes($posts_info  ['post_owner']);
        //add to display
        $display_block .= <<<END_OF_TEXT
        <tr>
        <td>$post_owner<br/><br/>
        created on:<br/>$post_create_time</td>
        <td>$post_text<br/><br/>
        <a href="replytopost.php?post_id=$post_id">
        <strong>REPLY TO POST</strong></a></td>
        </tr>
        END_OF_TEXT;
    }
    //free results
    mysqli_free_result($get_posts_res);
    mysqli_free_result($verify_topic_res);
    //close connection to MySQL
    mysqli_close($mysqli);
    //close up the table
    $display_block .=<<<END_OF_TEXT
    </table>
    END_OF_TEXT;
  }
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
    <h1>Posts in Topic</h1>
    <div class="content2">
<?php echo $display_block; ?>
</div>
</div>
    

</body>  
  <footer><p><a href="https://www.instagram.com/"><img alt="Photo" src="../ass/images/instagram_small.png"></a><a href="https://www.facebook.com/"><img alt="Photo" src="../ass/images/facebook_small.png"></a></p> <p>Privacy Policy: We collect and utilize the information that you provide to us voluntarily.</p><p>CopyRight Ⓒ</p></footer>
</html>