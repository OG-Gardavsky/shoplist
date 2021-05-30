<?php
    require 'inc/db.php';
    require 'user_required.php';

    $pageTitle='Delete shop list';
    include 'inc/header.php';

    $errors = [];

    $shopListId = !empty($_REQUEST['shopListId'])?$_REQUEST['shopListId']:null;


    if ($shopListId != null) {

        $shopListToDeleteQuery = $db->prepare("SELECT * FROM sl_shop_lists WHERE id = ? AND user_id = ? LIMIT 1");
        try {
            $shopListToDeleteQuery->execute([$shopListId, $currentUserId]);

            if ($shopListToDeleteQuery->rowCount() == 0) {
                $errors['genericError'] = 'Shopping list does not exist';
            } else {
                $shopListToDelete = $shopListToDeleteQuery->fetch(PDO::FETCH_ASSOC);
            }

        } catch (Exception $exception) {
            $errors['genericError'] = 'Unexpected application error';
        }

        //in case of submitting delete
        if(isset($_POST['delListBtn'])) {
            $shopListToDeleteQuery = $db->prepare("DELETE FROM sl_shop_lists WHERE id = ? AND user_id = ? LIMIT 1");
            try {
                $shopListToDeleteQuery->execute([$shopListId, $currentUserId]);
            } catch (Exception $exception) {
                $errors['genericError'] = 'Unexpected application error';
            }
            header('location: index.php');
        }


        if (isset($shopListToDelete)) {
            echo '<div class="alert alert-info">Are you sure you want to delete:"'.
                $shopListToDelete['name']
                .'" shopping list(including all items)</div>';
        }

    } else {
        $errors['genericError'] = 'No shop list to delete';
    }





    if (!empty($errors['genericError'])) {
        echo '<div class="alert alert-danger">' . $errors['genericError'] . '</div>';
    }


?>
    <form method="post">
        <input type="submit" class="btn btn-danger" name="delListBtn" value="Delete list" />
        <a href="index.php" class="btn btn-light">Back</a>
    </form>






<?php
    include 'inc/footer.php';
?>