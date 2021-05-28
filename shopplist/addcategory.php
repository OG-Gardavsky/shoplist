<?php
    require 'inc/db.php';
    require 'user_required.php';

    $userId = $_SESSION["user_id"];
    $errors=[];

    if (!empty(@$_POST['name'])) {

        $categoryName =  trim(@$_POST['name']);


        $duplicityCheck = $db->prepare("SELECT * FROM sl_categories WHERE user_id = ? AND name = ?");
        try {
            $duplicityCheck->execute([$userId, $categoryName]);
            if ($duplicityCheck->rowCount() != 0) {
                $errors['name'] = 'Category with this name already exists';
            }
        } catch (Exception $exception) {
            $errors['genericError'] = 'Unexpected application error';
        }

        if (empty($errors)) {

            try {
                $insertCategory = $db->prepare("INSERT INTO sl_categories(user_id, name) VALUES (?, ?)");
                $insertCategory->execute([$userId, $categoryName]);

                $createdCategoryQuery = $db->prepare("SELECT name FROM sl_categories WHERE name = ? AND user_id = ?  LIMIT 1");
                $createdCategoryQuery->execute([$categoryName, $userId]);

                $createdCategoryName = $createdCategoryQuery->fetch(PDO::FETCH_ASSOC);

//                echo strval($createdCategoryName['name']);

            } catch (Exception $exception) {
                $errors['genericError'] = 'Unexpected application error';
            }




        }




    }







    $pageTitle='Add new category';
    include 'inc/header.php';

?>

<!--    --><?php
//        echo 'user id: '.$userId.'<br/>';
//
//        foreach ($existingCategories as $category) {
//            echo $category['id'];
//        }
//
//    ?>


    <form method="post">
        <div class="form-group">
            <label for="name">Name of category</label>
            <input type="text" name="name" id="name" required class="form-control <?php echo (!empty($errors['name'])?'is-invalid':''); ?>"
                   value="<?php echo htmlspecialchars( trim(@$_POST['name']) ); ?>" />
            <?php
                if (!empty($errors['name'])){
                    echo '<div class="invalid-feedback">'.$errors['name'].'</div>';
                }
            ?>
        </div>

        <?php if (!empty($errors['genericError'])) { echo '<div class="alert alert-danger">'.$errors['genericError'].'</div>';  } ?>


        <button type="submit" class="btn btn-primary">Add category</button>
        <a href="addlist.php" class="btn btn-light">back to shop list</a>
    </form>


<?php
include 'inc/footer.php';
?>