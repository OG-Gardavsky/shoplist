<?php
    require 'inc/db.php';
    require 'user_required.php';

    $errors = [];

    if (isset($_GET['categoryId']) && $_GET['categoryId'] != null) {
        $shopListsQuery = $db->prepare("SELECT sl_shop_lists.id AS shopListId, sl_shop_lists.name AS 'listName', sl_shop_lists.finished, sl_categories.name AS 'categoryName' FROM sl_shop_lists JOIN sl_categories ON sl_shop_lists.category_id=sl_categories.id WHERE sl_shop_lists.user_id = ? AND sl_shop_lists.category_id=?");
        try {
            $shopListsQuery->execute([$currentUserId, $_GET['categoryId']]);
            $shopLists = $shopListsQuery->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $exception) {
            $errors['genericError'] = 'Unexpected application error';
        }
    } else {
//        $shopListsQuery = $db->prepare("SELECT sl_shop_lists.id AS shopListId, sl_shop_lists.name AS 'listName', sl_shop_lists.finished, sl_categories.name AS 'categoryName' FROM sl_shop_lists JOIN sl_categories ON sl_shop_lists.category_id=sl_categories.id WHERE sl_shop_lists.user_id = ?");
        $shopListsQuery = $db->prepare("SELECT id AS 'shopListId', name AS 'listName', finished FROM sl_shop_lists WHERE user_id = 1");
        try {
            echo 'je to tady';
            $shopListsQuery->execute([$currentUserId]);

            echo $shopListsQuery ->rowCount();

            $shopLists = $shopListsQuery->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $exception) {
            $errors['genericError'] = 'Unexpected application error';
        }
    }


    $pageTitle='';
    include 'inc/header.php';


?>
<!-- selecting category   -->
    <form method="get" class="form-group" id="categoryFilterForm">
        <label for="categoryId">Filter by category:</label>
        <select name="categoryId" id="categoryId" class="form-control" onchange="document.getElementById('categoryFilterForm').submit();" >
            <option value="">--choose category--</option>
            <?php

                $categoryListQuery = $db->prepare("SELECT * FROM sl_categories WHERE user_id = ?");
                try {
                    $categoryListQuery->execute([$currentUserId]);
                    $categoryList = $categoryListQuery->fetchAll(PDO::FETCH_ASSOC);

                } catch (Exception $exception) {
                    $errors['genericError'] = 'Unexpected application error';
                }

                if (!empty($categoryList)){
                    foreach ($categoryList as $category){
                        echo '<option value="'.$category['id'].'"'
                            .($category['id']==@$_GET['categoryId']?'selected="selected"':'').'>'
                            .htmlspecialchars($category['name'])
                            .'</option>';
                    }
                }
            ?>
        </select>
    </form>

    <a href="categoryManagement.php" class="btn btn-secondary">Category management</a>
    <a href="editShopList.php" class="btn btn-primary">Add new shopping list</a>

<!--  displaying shoping lists  -->
    <?php
        if (isset($shopLists)) {

            foreach ($shopLists as $shopList) {
                echo
                    '<div class="card">
                <div class="card-header flexRow cardContent">
                    <div>
                        <span class="badge badge-info">'.htmlspecialchars($shopList['categoryName']).'</span>
                        <span>'.htmlspecialchars($shopList['listName']).'</span>
                    </div>
                    <div>
                        <a href="deleteList.php?shopListId='.$shopList['shopListId'].'" class="btn btn-danger">X</a>
                        <a href="editShopList.php?shopListId='.$shopList['shopListId'].'" class="btn btn-secondary">edit / view</a>
                        <a href="markListAsFinished.php?shopListId='.$shopList['shopListId'].'" class="btn success">';
                if ($shopList['finished'] == false) {
                    echo '&nbsp;&nbsp;&nbsp;';
                } else {
                    echo '✓';
                }
                echo '</a>
                    </div>
                </div>
            </div>';

            }

        }

    ?>



<?php
    include 'inc/footer.php';
?>