<?php
    require 'inc/db.php';
    require 'user_required.php';



    $pageTitle='Add new category';
    include 'inc/header.php';

?>


    <form method="post">
        <div class="form-group">
            <label for="name">Name of category</label>
            <input type="text" name="name" id="name" required class="form-control" />
        </div>


        <button type="submit" class="btn btn-primary">Add category</button>
        <a href="addlist.php" class="btn btn-light">back to shop list</a>
    </form>


<?php
include 'inc/footer.php';
?>