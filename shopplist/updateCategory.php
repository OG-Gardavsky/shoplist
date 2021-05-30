<?php

    $maxNameCharLength = 50;

    require 'inc/db.php';
    require 'user_required.php';

    $pageTitle='Add new item to list';
    include 'inc/header.php';

    $errors = [];

    $categoryId = !empty($_REQUEST['categoryId'])?$_REQUEST['categoryId']:null;
    $shopListId = !empty($_REQUEST['shopListId'])?intval($_REQUEST['shopListId']):null;



    if ($categoryId != null && !isset($_POST['SaveItemBtn'])) {

        $categoryToUpdateQuery = $db->prepare("SELECT * FROM sl_categories WHERE id = ? AND user_id = ?LIMIT 1");
        try {
            $categoryToUpdateQuery->execute([$categoryId, $currentUserId]);

            if ($categoryToUpdateQuery->rowCount() == 0) {
                $errors['genericError'] = 'Category does not exist';
            } else {
                $categoryToUpdate = $categoryToUpdateQuery->fetch(PDO::FETCH_ASSOC);
                $_POST['nameOfCategory']= $categoryToUpdate['name'];
            }

        } catch (Exception $exception) {
            $errors['genericError'] = 'Unexpected application error';
        }

    } else if ($categoryId != null && isset($_POST['SaveItemBtn'])) {

        $nameOfCategory = trim($_POST['nameOfCategory']);

        $categoryToUpdateQuery = $db->prepare("SELECT * FROM sl_categories WHERE id = ? AND user_id = ?LIMIT 1");
        try {
            $categoryToUpdateQuery->execute([$categoryId, $currentUserId]);

            if ($categoryToUpdateQuery->rowCount() == 1) {

                $updateQuery=$db->prepare('UPDATE sl_categories SET name=:nameOfCategory WHERE id=:categoryId AND user_id=:userId LIMIT 1;');
                try {

                    $updateQuery->execute([
                        ':nameOfCategory'=> $nameOfCategory,
                        ':categoryId'=> $categoryId,
                        ':userId'=>$currentUserId
                    ]);

                    header('location: categoryManagement.php?shopListId='.$shopListId);


                } catch (Exception $exception) {
                    $errors['genericError'] = 'Unexpected application error';
                }

            } else {
                $errors['genericError'] = 'Category does not exist';
            }

        } catch (Exception $exception) {
            $errors['genericError'] = 'Unexpected application error';
        }
    }







?>

    <form method="post">

        <div class="flexRow">

            <div class="form-group">
                <label for="neco">Name of Category</label>
                <input type="text" name="nameOfCategory" class="form-control <?php echo (!empty($errors['nameOfCategory'])?'is-invalid':''); ?>"

                       value="<?php echo htmlspecialchars(@$_POST['nameOfCategory']) ?>" />
                <?php
                    if (!empty($errors['nameOfCategory'])){
                        echo '<div class="invalid-feedback">'.$errors['nameOfCategory'].'</div>';
                    }
                ?>
            </div>

        </div>

        <?php
            if (!empty($errors['genericError'])) {
                echo '<div class="alert alert-danger">' . $errors['genericError'] . '</div>';
            }
        ?>

        <input type="submit" class="btn btn-primary" name="SaveItemBtn" value="Save category" />
        <a href="categoryManagement.php?shopListId=<?php echo $shopListId?>" class="btn btn-light">Back</a>
    </form>




<?php
include 'inc/footer.php';
?>