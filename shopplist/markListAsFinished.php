<?php
    require 'inc/db.php';
    require 'user_required.php';




    $shopListId = !empty($_REQUEST['shopListId'])?$_REQUEST['shopListId']:null;


    if ($shopListId != null) {

        $shopListToUpdateQuery = $db->prepare("SELECT * FROM sl_shop_lists WHERE id = ? AND user_id = ? LIMIT 1");
        try {
            $shopListToUpdateQuery->execute([$shopListId, $currentUserId]);
        } catch (Exception $exception) {
            header('location: index.php');
        }

        $shopListToMarkAsDone = $shopListToUpdateQuery->fetch(PDO::FETCH_ASSOC);

        $saveQuery=$db->prepare('UPDATE sl_shop_lists SET finished=:finished WHERE id=:shopListId LIMIT 1;');



        try {
            $saveQuery->execute([
                ':shopListId'=>$shopListToMarkAsDone['id'],
                ':finished'=>$shopListToMarkAsDone['finished'] == 0 ? 1 : 0
            ]);
            header('location: index.php');
        } catch (Exception $exception) {
            header('location: index.php');
        }



    } else {
        header('location: index.php');
    }







?>
