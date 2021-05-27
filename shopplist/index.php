<?php
    require 'inc/db.php';

    require 'user_required.php';




    $pageTitle='';
    include 'inc/header.php';


?>

    <h1>
        your shopping lists
    </h1>

    <a href="addlist.php" class="btn btn-primary">Add new shopping list</a>


<?php
    include 'inc/footer.php';
?>