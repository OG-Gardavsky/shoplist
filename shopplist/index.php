<?php
    require 'inc/db.php';
    require 'user_required.php';

    $errors = [];

    if (isset($_GET['categoryId']) && $_GET['categoryId'] != null) {
        $shopListsQuery = $db->prepare("SELECT sl_shop_lists.id AS 'shopListId', sl_shop_lists.name AS 'listName', sl_shop_lists.finished FROM sl_shop_lists JOIN sl_categories_and_lists ON sl_categories_and_lists.shop_list_id = sl_shop_lists.id WHERE sl_shop_lists.user_id = ? AND sl_categories_and_lists.category_id = ?");
        try {
            $shopListsQuery->execute([$currentUserId, $_GET['categoryId']]);
            $shopLists = $shopListsQuery->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $exception) {
            $errors['genericError'] = 'Unexpected application error';
        }
    } else {
        $shopListsQuery = $db->prepare("SELECT id AS 'shopListId', name AS 'listName', finished FROM sl_shop_lists WHERE user_id = 1");
        try {
            $shopListsQuery->execute([$currentUserId]);

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
                        echo '<option value="'.$category['id'].'"';
                        echo ($category['id']==@$_GET['categoryId']?'selected="selected"':'').'>';
                        echo htmlspecialchars($category['name']).'</option>';
                    }
                }
            ?>
        </select>
    </form>

    <a href="categoryManagement.php" class="btn btn-secondary">Category management</a>
    <a href="editShopList.php" class="btn btn-primary">Add new shopping list</a>

<!--  displaying shoping lists  -->
    <?php
        if (isset($shopLists) && count($shopLists) > 0) {

            $asociatedCategoriesQuery = $db->prepare("SELECT name FROM sl_categories_and_lists JOIN sl_categories ON sl_categories_and_lists.category_id=sl_categories.id WHERE shop_list_id = ?");

            foreach ($shopLists as $shopList) {
                echo
                    '<div class="card">
                <div class="card-header flexRow cardContent">
                    <div>';

                    try {
                        $asociatedCategoriesQuery->execute([$shopList['shopListId']]);
                        $asociatedCategories = $asociatedCategoriesQuery->fetchAll(PDO::FETCH_ASSOC);

                    } catch (Exception $exception) {
                        $errors['genericError'] = 'Unexpected application error';
                    }

                    if ($asociatedCategories) {
                        foreach ($asociatedCategories as $category) {
                            echo '<span class="badge badge-info margin5">' .htmlspecialchars($category['name']).'</span>';
                        }
                    }

                    echo
                        '<span>'.htmlspecialchars($shopList['listName']).'</span>
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

        } else if (isset($shopLists) && count($shopLists) < 1) {
            echo '<div class="alert alert-info" style="margin-top: 10px">No shopping list in selected category, select different one.</div>';
        }

    ?>



<?php
    include 'inc/footer.php';
?>