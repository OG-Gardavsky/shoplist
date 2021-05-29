<?php
    require 'inc/db.php';
    require 'user_required.php';

    $errors = [];

    $shopListId = !empty($_REQUEST['shopListId'])?$_REQUEST['shopListId']:'';

    $shopListToDeleteQuery = $db->prepare("SELECT * FROM sl_shop_lists WHERE id = ? AND user_id = ? LIMIT 1");
    try {
        $shopListToDeleteQuery->execute([$shopListId, $currentUserId]);

        if ($shopListToDeleteQuery->rowCount() == 0) {
            $errors['genericError'] = 'Shopping list does not exist';
        } else {
            $shopListToDelete = $shopListToDeleteQuery->fetch(PDO::FETCH_ASSOC);
        }

    } catch (Exception $exception) {
        echo $exception;
        $errors['genericError'] = 'Unexpected application error';
    }





    $pageTitle='Delete shop list';
    include 'inc/header.php';


    if (isset($shopListToDelete)) {
        echo '<div class="alert alert-info">Are you sure you want to delete:"'.
              $shopListToDelete['name']
            .'" shopping list(including all items)</div>';
    }

    if (!empty($errors['genericError'])) {
        echo '<div class="alert alert-danger">' . $errors['genericError'] . '</div>';
    }

?>





<?php
    include 'inc/footer.php';
?>