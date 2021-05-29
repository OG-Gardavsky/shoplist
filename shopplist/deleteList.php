<?php
    require 'inc/db.php';
    require 'user_required.php';

    $shopListId = !empty($_REQUEST['shopListId'])?$_REQUEST['shopListId']:'';

    $shopListToDeleteQuery = $db->prepare("SELECT * FROM sl_shop_lists WHERE id = ? AND user_id = ? LIMIT 1");
    try {
        $shopListToDeleteQuery->execute([$shopListId, $currentUserId]);
        $shopListToDelete = $shopListToDeleteQuery->fetch(PDO::FETCH_ASSOC);

    } catch (Exception $exception) {
        $errors['genericError'] = 'Unexpected application error';
    }



    $pageTitle='Delete shop list';
    include 'inc/header.php';




?>

    <div class="alert alert-info">
        Are you sure you want to delete: "<?php echo $shopListToDelete['name'] ?>" shopping list(including all items)?
    </div>

<?php if (!empty($errors['genericError'])) { echo '<div class="alert alert-danger">'.$errors['genericError'].'</div>';  } ?>




<?php
    include 'inc/footer.php';
?>