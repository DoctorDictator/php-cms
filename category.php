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


      if (isset($_GET['category'])) {
        $post_category_title = mysqli_real_escape_string($connection, $_GET['category']);

        // Assuming you have a 'categories' table
        $cat_query = "SELECT cat_id FROM categories WHERE cat_title = '{$post_category_title}'";
        $cat_result = mysqli_query($connection, $cat_query);

        if ($cat_row = mysqli_fetch_assoc($cat_result)) {
          $post_category_id = $cat_row['cat_id'];

          // Now fetch all posts with this category ID
          $query = "SELECT * FROM posts WHERE post_category_id = {$post_category_id} AND post_status = 'published'";
          $select_all_posts_query = mysqli_query($connection, $query);

          while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
            $post_title = $row['post_title'];
            $post_user = $row['post_user'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = substr($row['post_content'], 0, 400);
            $slug = $row['slug'];
            $post_id = $row['post_id'];
      ?>
            <div class="col-md-6" style="box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: all 0.3s ease; padding: 15px; border-radius: 8px;" onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)'" onmouseout="this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
              <a href="/cms/post/<?php echo $slug; ?>">
                <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="" style="border-radius: 4px;">
              </a>
              <h2>
                <a href="/cms/post/<?php echo $slug ?>" style="text-decoration: none; color: #333;"><?php echo $post_title ?></a>
              </h2>
              <div class="row">
                <div class="col-md-6">
                  <p class="lead" style="font-size: 16px; margin-bottom: 10px;">
                    by <a href="/cms/author_posts.php?author=<?php echo $post_user ?>" style="color: #007bff;"><?php echo $post_user ?></a>
                  </p>
                </div>
                <div class="col-md-6">
                  <p class="lead" style="font-size: 15px; margin-top: 2px; color: #666;">
                    <span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?>
                  </p>
                </div>
              </div>
              <p style="color: #444; line-height: 1.6;"><?php echo $post_content ?></p>
              <hr style="border-color: #ddd;">
            </div>
      <?php
          } // end while
        } else {
          echo "<p>No category found with this title.</p>";
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