<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            if (isset($_GET['slug'])) {
                $the_post_slug = mysqli_real_escape_string($connection, $_GET['slug']);

                // First, get the post_id based on the slug
                $query = "SELECT post_id FROM posts WHERE slug = '$the_post_slug'";
                $post_id_query = mysqli_query($connection, $query);

                if ($post_id_query && mysqli_num_rows($post_id_query) > 0) {
                    $row = mysqli_fetch_assoc($post_id_query);
                    $the_post_id = $row['post_id'];

                    // Update view count
                    $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id";
                    mysqli_query($connection, $view_query);

                    // Get post details
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                    $select_all_posts_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id      = $row['post_id'];
                        $post_title   = $row['post_title'];
                        $post_author  = $row['post_author'];
                        $post_user  = $row['post_user'];

                        $post_date    = $row['post_date'];
                        $post_image   = $row['post_image'];
                        $post_content = $row['post_content'];
            ?>
                        <!-- First Blog Post -->
                        <h2>
                            <a href="#"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="../author_posts/<?php echo $post_user ?>"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <?php echo $post_content ?>

                        <hr>

                        <div class="well">
                            <h4>Leave a Comment:</h4>
                            <form action="" method="post" role="form">
                                <div class="form-group">
                                    <label for="Author">Author</label>
                                    <input type="text" name="comment_author" class="form-control" name="comment_author">
                                </div>
                                <div class="form-group">
                                    <label for="Author">Email</label>
                                    <input type="email" name="comment_email" class="form-control" name="comment_email">
                                </div>
                                <div class="form-group">
                                    <label for="comment">Your Comment</label>
                                    <textarea name="comment_content" class="form-control" rows="3"></textarea>
                                </div>
                                <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <hr>
                        <div class="clearfix"></div>
                    <?php
                    }
                    ?>
                    <!-- Blog Comments -->
                    <?php
                    if (isset($_POST['create_comment'])) {
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];

                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                            $query .= "VALUES ($the_post_id ,'{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";
                            $create_comment_query = mysqli_query($connection, $query);
                            if (!$create_comment_query) {
                                die('QUERY FAILED' . mysqli_error($connection));
                            }
                        }
                    }
                    ?>
                    <!-- Posted Comments -->
                    <?php
                    $query = "SELECT * FROM comments WHERE comment_post_id = $the_post_id ";
                    $query .= "AND comment_status = 'approved' ";
                    $query .= "ORDER BY comment_id DESC ";
                    $select_comment_query = mysqli_query($connection, $query);
                    if (!$select_comment_query) {
                        die('Query Failed' . mysqli_error($connection));
                    }
                    while ($row = mysqli_fetch_array($select_comment_query)) {
                        $comment_date   = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];
                    ?>
                        <!-- Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author; ?>
                                    <small><?php echo $comment_date; ?></small>
                                </h4>
                                <?php echo $comment_content; ?>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    header("Location: index.php");
                }
            } else {
                header("Location: index.php");
            }
            ?>
        </div>
        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>
    </div>
    <!-- /.row -->
    <hr>
    <?php include "includes/footer.php"; ?>