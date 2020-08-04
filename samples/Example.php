<?php
/*** EXAMPLE OF USE ***/
//We must include the class "Post.php" in order to get it working
include("Post.php");
//We now create a new post Object:
$p = new Post();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Example webpage</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <h2>Posts:</h2>
        <div class="container">
            <?php
            for($i=0;$i<sizeof($p->getAllPosts());$i++){
            ?>
            <div class="row">
                <div class="col-md-12">
                    <h3><?php echo htmlentities($p->getPost($post_id)['post_title']);?></h3>
                    <h3>Title: <?php echo htmlentities($p->getPost($post_id)['title']);?></h3>
                    <h3>Author: <?php echo htmlentities($p->getPost($post_id)['author']);?></h3>
                    <h3>Language: <?php echo htmlentities($p->getPost($post_id)['language']);?></h3>
                    <p><?php echo htmlentities($p->getPost($post_id)['summary']);?> ?></p>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </body>
</html>