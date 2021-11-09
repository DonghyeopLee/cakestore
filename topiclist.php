<?php
  require_once("connection.php");
    //gather the topics
    $get_topics_sql = "SELECT topic_id, topic_title,
    DATE_FORMAT(topic_create_time,  '%b %e %Y at %r') AS fmt_topic_create_time, topic_owner FROM forum_topics
    ORDER BY topic_create_time DESC"; 
    $get_topics_res = mysqli_query($mysqli, $get_topics_sql)
    or die(mysqli_error($mysqli));
    if (mysqli_num_rows($get_topics_res) < 1) {
    //there are no topics, so say so
    $display_block = "<p><em>No topics exist.</em></p>";
    } 
    else {
    //create the display string
        $display_block = <<<END_OF_TEXT
        <table>
        <tr><th>Review title</th>
        <th>num of POSTS</th>
        </tr>        
        END_OF_TEXT;
    
        while ($topic_info = mysqli_fetch_array($get_topics_res)) {
            $topic_id = $topic_info['topic_id'];
            $topic_title = stripslashes($topic_info['topic_title']);
            $topic_create_time = $topic_info['fmt_topic_create_time'];
            $topic_owner = stripslashes($topic_info['topic_owner']);
            //get number of posts
            $get_num_posts_sql = "SELECT COUNT(post_id) AS post_count FROM
            forum_posts WHERE topic_id = '".$topic_id."'";
            $get_num_posts_res = mysqli_query($mysqli, $get_num_posts_sql)
            or die(mysqli_error($mysqli));
                while ($posts_info = mysqli_fetch_array($get_num_posts_res)) {
                    $num_posts = $posts_info['post_count'];
                }
            //add to display
            $display_block .= <<<END_OF_TEXT
            <tr>
            <td><a href="showreview.php?topic_id=$topic_id">
            <strong>$topic_title</strong></a><br/>
            Created on $topic_create_time by $topic_owner</td>
            <td class="num_posts_col">$topic_id</td>
            </tr> 
            END_OF_TEXT;
        }
        //free results
        mysqli_free_result($get_topics_res);
        mysqli_free_result($get_num_posts_res);
        //close connection to MySQL
        mysqli_close($mysqli);
        //close up the table
        $display_block .= <<<END_OF_TEXT
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
    <h1>cake review</h1>
    <p>let us know your review</p>
    <div class="content2">
    <?php echo $display_block; ?>
</div>
 <p>Would you like to <a href="addtopic.html">add a topic</a>?</p> 
 </div>

    <footer><p><a href="https://www.instagram.com/"><img alt="Photo" src="../ass/images/instagram_small.png"></a><a href="https://www.facebook.com/"><img alt="Photo" src="../ass/images/facebook_small.png"></a></p> <p>Privacy Policy: We collect and utilize the information that you provide to us voluntarily.</p><p>CopyRight Ⓒ</p></footer>

</body>  
  
</html>