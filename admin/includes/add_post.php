<?php


if (isset($_POST['create_post'])) {

    $post_title        = escape($_POST['title']);
    $post_slug = strtolower(preg_replace('/[^A-Za-z0-9]+/', '-', trim($post_title)));
    $post_user         = escape($_POST['post_user']);
    $post_author = '';
    $users_query = "SELECT * FROM users WHERE username='$post_user'";
    $select_users = mysqli_query($connection, $users_query);

    confirmQuery($select_users);


    while ($row = mysqli_fetch_assoc($select_users)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $post_author = trim($user_firstname . ' ' . $user_lastname);
    }


    $post_category_id  = escape($_POST['post_category']);
    $post_status       = escape($_POST['post_status']);

    $post_image        = escape($_FILES['image']['name']);
    $post_image_temp   = escape($_FILES['image']['tmp_name']);


    $post_tags = escape($_POST['post_tags']);
    $tags_array = array_map('trim', explode(',', $post_tags));
    $tags_array = array_filter($tags_array); // Remove empty tags
    $escaped_tags = array_map(function ($tag) use ($connection) {
        return mysqli_real_escape_string($connection, $tag);
    }, $tags_array);
    $post_tags = implode(',', $escaped_tags);
    $post_content      = escape($_POST['post_content']);
    $post_date         = escape(date('d-m-y'));


    move_uploaded_file($post_image_temp, "../images/$post_image");


    $query = "INSERT INTO posts(post_category_id, post_author,post_title,slug, post_user, post_date,post_image,post_content,post_tags,post_status) ";

    $query .= "VALUES({$post_category_id},'{$post_author}','{$post_title}','{$post_slug}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') ";

    $create_post_query = mysqli_query($connection, $query);

    confirmQuery($create_post_query);

    $the_post_id = mysqli_insert_id($connection);


    echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
}




?>

<form action="" method="post" enctype="multipart/form-data">


    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <select name="post_category" id="">

            <?php

            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);

            confirmQuery($select_categories);


            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];


                echo "<option value='$cat_id'>{$cat_title}</option>";
            }

            ?>


        </select>

    </div>


    <div class="form-group">
        <label for="users">Users</label>
        <select name="post_user" id="">

            <?php

            $users_query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $users_query);

            confirmQuery($select_users);


            while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                $user_firstname = $row['user_firstname'];
                $user_lastname = $row['user_lastname'];



                echo "<option value='{$username}'>{$username}</option>";
            }

            ?>


        </select>

    </div>





    <!-- <div class="form-group">
         <label for="title">Post Author</label>
          <input type="text" class="form-control" name="author">
      </div> -->



    <div class="form-group">
        <select name="post_status" id="">
            <option value="draft">Post Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>



    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="post_content" cols="30" rows="10"></textarea>
    </div>

    <script>
        CKEDITOR.replace('post_content', {
            toolbar: [{
                    name: 'document',
                    items: ['Source', '-', 'NewPage', 'Preview', '-', 'Templates']
                },
                {
                    name: 'clipboard',
                    items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
                },
                {
                    name: 'editing',
                    items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']
                },
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink', 'Anchor']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']
                },
                {
                    name: 'styles',
                    items: ['Styles', 'Format', 'Font', 'FontSize']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'tools',
                    items: ['Maximize', 'ShowBlocks']
                }
            ],
            height: 300,
            width: '100%',
            resize_enabled: true,
            language: 'en'
        });
    </script>



    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>


</form>