<?php
    require 'inc/db.php';
    require 'user_required.php';


    $itemId = !empty($_REQUEST['itemId'])?$_REQUEST['itemId']:null;
    $shopListId = !empty($_REQUEST['shopListId'])?intval($_REQUEST['shopListId']):null;



    if ($itemId != null) {


        $itemSelectQuery = $db->prepare("SELECT * FROM sl_items WHERE id = ? LIMIT 1");
        try {
            $itemSelectQuery->execute([$itemId]);
            $selectedItem = $itemSelectQuery->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $exception) {
            header('location: editShopList.php?shopListId='.$shopListId);
        }



        $saveQuery=$db->prepare('UPDATE sl_items SET bought=:bought WHERE id=:itemId LIMIT 1;');



        try {
            $saveQuery->execute([
                ':itemId'=>$selectedItem['id'],
                ':bought'=>$selectedItem['bought'] == 0 ? 1 : 0
            ]);
            header('location: editShopList.php?shopListId='.$shopListId);
        } catch (Exception $exception) {
            header('location: editShopList.php?shopListId='.$shopListId);
        }



    } else if ($shopListId != null) {
        header('location: editShopList.php?shopListId='.$shopListId);
    } else {
        header('location: index.php');
    }







?>
