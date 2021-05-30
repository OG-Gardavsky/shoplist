<?php
    require 'inc/db.php';
    require 'user_required.php';

    $pageTitle='Delete category';
    include 'inc/header.php';

    $errors = [];

    $categoryId = !empty($_REQUEST['categoryId'])?$_REQUEST['categoryId']:null;
    $shopListId = !empty($_REQUEST['shopListId'])?intval($_REQUEST['shopListId']):null;

    if ($categoryId != null) {

        $categoryToDeleteQuery = $db->prepare("SELECT * FROM sl_categories WHERE id = ? AND user_id = ? LIMIT 1");
        try {
            $categoryToDeleteQuery->execute([$categoryId, $currentUserId]);

            if ($categoryToDeleteQuery->rowCount() == 0) {
                $errors['genericError'] = 'Item does not exist';
            } else {
                $categoryToDelete = $categoryToDeleteQuery->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $exception) {
            $errors['genericError'] = 'Unexpected application error';
        }

        //in case of submitting delete
        if(isset($_POST['dellCategoryBtn'])) {
            $categoryToDeleteQuery = $db->prepare("DELETE FROM sl_categories WHERE id = ? AND user_id = ? LIMIT 1");
            try {
                $categoryToDeleteQuery->execute([$categoryId, $currentUserId]);
                header('location: editCategory.php?shopListId='.$shopListId);
            } catch (Exception $exception) {
                $errors['genericError'] = 'Unexpected application error';
            }

        }

        if (isset($categoryToDelete)) {
            echo '<div class="alert alert-info">Are you sure you want to delete:"'.
                $categoryToDelete['name']
                .'" category(including all related shopping lists)?</div>';
        }

    } else {
        $errors['genericError'] = 'No item to delete';
    }





    if (!empty($errors['genericError'])) {
        echo '<div class="alert alert-danger">' . $errors['genericError'] . '</div>';
    }


?>
    <form method="post">
        <input type="submit" class="btn btn-danger" name="dellCategoryBtn" value="DeleteItem" />
        <a href="editCategory.php?shopListId=<?php echo $shopListId?>" class="btn btn-light">Back</a>
    </form>






<?php
    include 'inc/footer.php';
?>