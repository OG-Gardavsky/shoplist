<?php
    require 'inc/db.php';
    require 'user_required.php';

    $pageTitle='Delete shop list';
    include 'inc/header.php';

    $errors = [];

    $itemId = !empty($_REQUEST['itemId'])?$_REQUEST['itemId']:null;
    $shopListId = !empty($_REQUEST['shopListId'])?intval($_REQUEST['shopListId']):null;

    if ($itemId != null) {

        $itemTodeleteQuery = $db->prepare("SELECT * FROM sl_items WHERE id = ? LIMIT 1");
        try {
            $itemTodeleteQuery->execute([$itemId]);

            if ($itemTodeleteQuery->rowCount() == 0) {
                $errors['genericError'] = 'Item does not exist';
            } else {
                $itemTodelete = $itemTodeleteQuery->fetch(PDO::FETCH_ASSOC);
            }

        } catch (Exception $exception) {
            $errors['genericError'] = 'Unexpected application error';
        }

        //in case of submitting delete
        if(isset($_POST['dellItemBtn'])) {
            $itemTodeleteQuery = $db->prepare("DELETE FROM sl_items WHERE id = ? LIMIT 1");
            try {
                $itemTodeleteQuery->execute([$itemId]);
            } catch (Exception $exception) {
                $errors['genericError'] = 'Unexpected application error';
            }
            header('location: editShopList.php?shopListId='.$shopListId);
        }


        if (isset($itemTodelete)) {
            echo '<div class="alert alert-info">Are you sure you want to delete:"'.
                $itemTodelete['name']
                .'" list item?</div>';
        }

    } else {
        $errors['genericError'] = 'No item to delete';
    }





    if (!empty($errors['genericError'])) {
        echo '<div class="alert alert-danger">' . $errors['genericError'] . '</div>';
    }


?>
    <form method="post">
        <input type="submit" class="btn btn-danger" name="dellItemBtn" value="DeleteItem" />
        <a href="editShopList.php?shopListId=<?php echo $shopListId?>" class="btn btn-light">Back</a>
    </form>






<?php
    include 'inc/footer.php';
?>