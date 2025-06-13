<?php include "includes/admin_header.php"; ?>
<?php


// Start session to get current user
// Ensure user is logged in
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo "<div>Error: User not logged in</div>";
    exit;
}

// Sanitize the current user
$current_user = mysqli_real_escape_string($connection, $_SESSION['username']);

// Initialize counters
$post_count = 0;
$comment_count = 0;
$category_count = 0;
$post_published_count = 0;
$post_draft_count = 0;
$approved_comment_count = 0;
$unapproved_comment_count = 0;

// 1. Count all user posts
$query = "SELECT * FROM posts WHERE post_user = '$current_user'";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "<div>Error in posts query: " . mysqli_error($connection) . "</div>";
    exit;
}
while ($row = mysqli_fetch_assoc($result)) {
    $post_count++;
}

// 2. Count all comments on user's posts
$query = "SELECT c.* FROM comments c 
          INNER JOIN posts p ON c.comment_post_id = p.post_id 
          WHERE p.post_user = '$current_user'";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "<div>Error in comments query: " . mysqli_error($connection) . "</div>";
    exit;
}
while ($row = mysqli_fetch_assoc($result)) {
    $comment_count++;
}

// 3. Count categories created by user (assuming categories are linked to user)
$query = "SELECT * FROM categories";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "<div>Error in categories query: " . mysqli_error($connection) . "</div>";
    exit;
}
while ($row = mysqli_fetch_assoc($result)) {
    $category_count++;
}

// 4. Count published posts
$query = "SELECT * FROM posts WHERE post_user = '$current_user' AND post_status = 'published'";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "<div>Error in published posts query: " . mysqli_error($connection) . "</div>";
    exit;
}
while ($row = mysqli_fetch_assoc($result)) {
    $post_published_count++;
}

// 5. Count draft posts
$query = "SELECT * FROM posts WHERE post_user = '$current_user' AND post_status = 'draft'";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "<div>Error in draft posts query: " . mysqli_error($connection) . "</div>";
    exit;
}
while ($row = mysqli_fetch_assoc($result)) {
    $post_draft_count++;
}

// 6. Count approved comments on user's posts
$query = "SELECT c.* FROM comments c 
          INNER JOIN posts p ON c.comment_post_id = p.post_id 
          WHERE p.post_user = '$current_user' AND c.comment_status = 'approved'";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "<div>Error in approved comments query: " . mysqli_error($connection) . "</div>";
    exit;
}
while ($row = mysqli_fetch_assoc($result)) {
    $approved_comment_count++;
}

// 7. Count unapproved comments on user's posts
$query = "SELECT c.* FROM comments c 
          INNER JOIN posts p ON c.comment_post_id = p.post_id 
          WHERE p.post_user = '$current_user' AND c.comment_status = 'unapproved'";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "<div>Error in unapproved comments query: " . mysqli_error($connection) . "</div>";
    exit;
}
while ($row = mysqli_fetch_assoc($result)) {
    $unapproved_comment_count++;
}

// Output the counts (for example, in a dashboard)

?>


<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to admin <?php echo strtoupper(get_user_name()); ?>
                    </h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php echo  "<div class='huge'>" . $post_count . "</div>" ?>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php echo  "<div class='huge'>{$comment_count}</div>" ?>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php echo  "<div class='huge'>{$category_count}</div>" ?>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div><!-- /.row -->

            <div class="row">

                <script type="text/javascript">
                    google.load("visualization", "1.1", {
                        packages: ["bar"]
                    });
                    google.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],

                            <?php

                            $element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Approved Comments', 'Pending Comments', 'Categories'];
                            $element_count = [$post_count, $post_published_count, $post_draft_count, $comment_count, $approved_comment_count, $unapproved_comment_count, $category_count];
                            for ($i = 0; $i < 7; $i++) {
                                echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                            }

                            ?>
                        ]);

                        var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, options);
                    }
                </script>


                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>

            </div>
        </div>
        <!-- /.container-fluid -->
    </div>

    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>



    <script>
        $(document).ready(function() {


            var pusher = new Pusher('a202fba63a209863ab62', {

                cluster: 'us2',
                encrypted: true
            });


            var notificationChannel = pusher.subscribe('notifications');


            notificationChannel.bind('new_user', function(notification) {

                var message = notification.message;

                toastr.success(`${message} just registered`);

            });



        });
    </script>