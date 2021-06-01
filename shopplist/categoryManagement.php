<?php

    $maxNameCharLength = 20;

    require 'inc/db.php';
    require 'user_required.php';


    $errors=[];
    $infoMessage = '';

    $shopListId = !empty($_REQUEST['shopListId'])?intval($_REQUEST['shopListId']):null;

    if (!empty(@$_POST['name'])) {

        $categoryName =  trim(@$_POST['name']);

        if (strlen($categoryName) > $maxNameCharLength) {
            $errors['name'] = 'lenght cannot be more than '.$maxNameCharLength.' characters';
        }

        if (empty($errors)) {

            $duplicityCheck = $db->prepare("SELECT * FROM sl_categories WHERE user_id = ? AND name = ?");
            try {
                $duplicityCheck->execute([$currentUserId, $categoryName]);
                if ($duplicityCheck->rowCount() != 0) {
                    $errors['name'] = 'Category with this name already exists';
                }
            } catch (Exception $exception) {
                $errors['genericError'] = 'Unexpected application error';
            }

            if (empty($errors)) {

                try {
                    $insertCategory = $db->prepare("INSERT INTO sl_categories(user_id, name) VALUES (?, ?)");
                    $insertCategory->execute([$currentUserId, $categoryName]);

                    $createdCategoryQuery = $db->prepare("SELECT name FROM sl_categories WHERE name = ? AND user_id = ?  LIMIT 1");
                    $createdCategoryQuery->execute([$categoryName, $currentUserId]);
                    $createdCategoryName = $createdCategoryQuery->fetch(PDO::FETCH_ASSOC);

                    $infoMessage = 'Category: '.strval($createdCategoryName['name']).' was successfully created.';
                    unset($_POST['name']);


                } catch (Exception $exception) {
                    $errors['genericError'] = 'Unexpected application error';
                }
            }
        }
    }


    $pageTitle='Add new category';
    include 'inc/header.php';

?>



    <form method="post">

<!--        name input-->
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

<!--        error displaying -->
        <?php
            //error displaying
            if (!empty($errors['genericError'])) { echo '<div class="alert alert-danger">'.$errors['genericError'].'</div>';  }

            if ($infoMessage != '') { echo '<div class="alert alert-info">'.$infoMessage.'</div>';  }
        ?>


        <button type="submit" class="btn btn-primary">Add category</button>
        <a class="btn btn-light" href="<?php
            if ($shopListId != null) {
                echo 'editShopList.php?shopListId='.$shopListId.'">back to shop list';
            } else {
                echo 'index.php'.'">back to home page';
            }
        ?></a>
    </form>

<!-- displaying of created categories -->
<?php

    $categoriesListQuery = $db->prepare("SELECT * FROM sl_categories WHERE user_id = ?");
    try {
        $categoriesListQuery->execute([$currentUserId]);
        if ($categoriesListQuery->rowCount() > 0) {
            $categoriesList = $categoriesListQuery->fetchAll(PDO::FETCH_ASSOC);
        }

    } catch (Exception $exception) {
        $errors['genericError'] = 'Unexpected application error';
    }

    if (isset($categoriesList)) {
        echo '<hr />';
        foreach ($categoriesList as $category) {

            echo '<div class="card">';
                echo '<div class="card-header flexRow cardContent">';

                    echo '<span>'.htmlspecialchars($category['name']).'</span>';

                    echo '<div>';
                        echo '<span> <a href="deleteCategory.php?categoryId='.$category['id'].'&shopListId='.$shopListId.'" class="btn btn-danger">X</a> </span>';
                        echo '<span> <a href="editCategory.php?categoryId='.$category['id'].'&shopListId='.$shopListId.'" class="btn btn-secondary">edit</a> </span>';
                    echo '</div>';

                echo '</div>';
            echo '</div>';
        }
    }




?>


<?php
include 'inc/footer.php';
?>