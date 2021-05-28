<?php
    require 'inc/db.php';
    require 'user_required.php';

    $userId = $_SESSION["user_id"];

    $stmt = $db->prepare("SELECT * FROM sl_categories WHERE user_id = ? LIMIT 1");
    $stmt->execute([$userId]);
    $existingCategories=$stmt->fetchAll(PDO::FETCH_ASSOC);





    $pageTitle='Add new category';
    include 'inc/header.php';

?>

    <?php
        echo 'user id: '.$userId.'<br/>';

        foreach ($existingCategories as $category) {
            echo $category['id'];
        }

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