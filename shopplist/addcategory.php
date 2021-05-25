<?php
require 'inc/db.php';



$pageTitle='Add new category';
include 'inc/header.php';

?>


    <form method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required class="form-control" />
        </div>


        <button type="submit" class="btn btn-primary">Add shopping list</button>
        <a href="addlist.php" class="btn btn-light">cancel</a>
    </form>


<?php
include 'inc/footer.php';
?>