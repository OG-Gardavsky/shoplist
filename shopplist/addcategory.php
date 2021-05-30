<?php
    require 'inc/db.php';
    require 'user_required.php';


    $errors=[];
    $infoMessage = '';

    if (!empty(@$_POST['name'])) {

        $categoryName =  trim(@$_POST['name']);

        //TODO check delky nazvu


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


<!--        TODO spravnej redirect-->
        <button type="submit" class="btn btn-primary">Add category</button>
        <a href="editShopList.php" class="btn btn-light">back to shop list</a>
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

    if ($categoriesList) {
        echo '<hr />';
        foreach ($categoriesList as $category) {

            echo '<div class="card">';
                echo '<div class="card-header flexRow cardContent">';

                    echo '<span>'.htmlspecialchars($category['name']).'</span>';

                    echo '<div>';
//                        echo '<a href="deleteListItem.php?itemId='.$listItem['id'].'&shopListId='.$listItem['shop_list_id'].'" type="button" class="btn btn-danger">X</a>'
                        echo '<a href="" type="button" class="btn btn-secondary">edit</a>';
                        echo '<a href="" type="button" class="btn btn-danger">X</a>';
                    echo '</div>';

                echo '</div>';
            echo '</div>';
        }
    }




?>


<?php
include 'inc/footer.php';
?>