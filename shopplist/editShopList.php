<?php
    $maxNameCharLength = 50;

    require 'inc/db.php';
    require 'user_required.php';


    $errors=[];
    $infoMessage = null;
    $selectedCategoryId=(!empty($_POST['categoryId'])?intval($_POST['categoryId']):'');
    $shopListId = !empty($_REQUEST['shopListId'])?intval($_REQUEST['shopListId']):null;

    //action for save button
    if(isset($_POST['saveShopListBtn'])) {

        if ($_POST['nameOfList'] == '' || $_POST['nameOfList'] == null ) {
            $errors['nameOfList'] = 'name cannot be blank';
        }

        //category field nejakej check

//        if ($_POST['categoryId'] == '' || $_POST['categoryId'] == null ) {
//            $errors['categoryId'] = 'category cannot be blank';
//        }


        if (empty($errors)) {
            $nameOfList = trim($_POST['nameOfList']);
//            $categoryId = $_POST['categoryId'];

            if (strlen($nameOfList) > $maxNameCharLength) {
                $errors['nameOfList'] = 'lenght cannot be more than '.$maxNameCharLength.' characters';
            }
        }

        // insert or update of shop list
        if (empty($errors)) {

            //insert of not saved list
            if ($shopListId == null) {

                $saveQuery=$db->prepare('INSERT INTO sl_shop_lists (user_id, name) VALUES (:userId, :name);');
                try {
                    $saveQuery->execute([
                        ':userId'=> $currentUserId,
                        ':name'=>$nameOfList
                    ]);


                    header('location: index.php');

                } catch (Exception $exception) {
                    $errors['genericError'] = 'Error during saving of shop list';
                }
            } else {
                //update of existing
                $updateQuery=$db->prepare('UPDATE sl_shop_lists SET name=:nameOfList WHERE id=:shopListId AND user_id=:currentUserId LIMIT 1;');
                $deleteCategoryQuery=$db->prepare('DELETE FROM sl_categories_and_lists WHERE shop_list_id = ?;');
                $insertCategoryQuery=$db->prepare('INSERT INTO sl_categories_and_lists (shop_list_id, category_id) VALUES (:shopListId, :categoryId);');

                try {

                    $updateQuery->execute([
                        ':nameOfList'=>$nameOfList,
                        ':shopListId'=>$shopListId,
                        ':currentUserId'=>$currentUserId
                    ]);

                    $deleteCategoryQuery->execute([$shopListId]);

                    if ( isset($_POST['category']) ) {

                        foreach($_POST['category'] as $value){
                            $insertCategoryQuery->execute([
                                ':shopListId'=>$shopListId,
                                ':categoryId'=>intval($value)
                            ]);
                        }
                    }

                    $infoMessage = 'Changes were successfully saved.';

                } catch (Exception $exception) {
                    echo $exception;
                    $errors['genericError'] = 'Error during saving of shop list';
                }
            }


        }
    }



    if ($shopListId != null) {

        $shopListToUpdateQuery = $db->prepare("SELECT * FROM sl_shop_lists WHERE id = ? AND user_id = ? LIMIT 1");
        try {
            $shopListToUpdateQuery->execute([$shopListId, $currentUserId]);

            if ($shopListToUpdateQuery->rowCount() == 0) {
                $errors['genericError'] = 'Shopping list does not exist';
            } else {
                $shopListToUpdate = $shopListToUpdateQuery->fetch(PDO::FETCH_ASSOC);
            }

            if (empty($errors)) {
                $_POST['nameOfList'] = $shopListToUpdate['name'];
            }


        } catch (Exception $exception) {
            $errors['genericError'] = 'Unexpected application error';
        }

    }




    $pageTitle='Add new list';

    $pageTitle = $shopListId != null ? 'Update list' : 'Add new list';




    include 'inc/header.php';

?>
<!-- List name -->
    <form method="post">
        <div class="form-group">
            <label for="name">Name of list</label>
            <input type="text" name="nameOfList" id="name" class="form-control <?php echo (!empty($errors['nameOfList'])?'is-invalid':''); ?>"
                    required
                value="<?php echo htmlspecialchars(@$_POST['nameOfList']) ?>"
            />
            <?php
                if (!empty($errors['nameOfList'])){
                    echo '<div class="invalid-feedback">'.$errors['nameOfList'].'</div>';
                }
            ?>
        </div>


<!-- category selection -->

<?php
    // for selecting categories
    if ($shopListId != null) {

        $categoryListQuery = $db->prepare("SELECT * FROM sl_categories WHERE user_id = ?");
        $checkedCategoriesQuery = $db->prepare("SELECT category_id FROM sl_categories_and_lists WHERE shop_list_id = ?");
        try {
            $categoryListQuery->execute([$currentUserId]);
            $checkedCategoriesQuery->execute([$shopListId]);

            $categoryList = $categoryListQuery->fetchAll(PDO::FETCH_ASSOC);
            $checkedCategories = $checkedCategoriesQuery->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $exception) {
            $errors['genericError'] = 'Unexpected application error';
        }

        //array of checked values
        $arrayOfCheckedCategories = [];
        foreach ($checkedCategories as $value) {
            array_push($arrayOfCheckedCategories, $value['category_id']);
        }

        // printing of checkboxes
        echo '<span>category</span>';
        echo '<div class="form-check flexRow">';
        echo '<label class="form-check-label"></label>';


            if (!empty($categoryList)) {
                foreach ($categoryList as $category) {
                    echo '<input type="checkbox" class="category" id="category'.$category['id'].'" name="category[]" value="'.$category['id'].'"';
                    if (in_array($category['id'], $arrayOfCheckedCategories)) { echo ' checked '; }
                    echo 'onclick="document.querySelector(\'#category'.$category['id'].'\').submit();" >'.$category['name'];
                }
            }

        echo '</div>';



        echo '<span> <a href="categoryManagement.php?shopListId='.$shopListId.'" class="btn btn-light">Category Management</a> </span>
        <hr />';
    }


?>









<!--displaying items -->

        <?php

            // check if exist shoplist in DB
            if ($shopListId != null) {
                echo '<h3>Shop list items</h3>';

                $shoplistItemsQuery = $db->prepare("SELECT * FROM sl_items WHERE shop_list_id = ?");
                try {
                    $shoplistItemsQuery->execute([$shopListId]);

                    if ($shoplistItemsQuery->rowCount() > 0 ) {
                        $shoplistItems = $shoplistItemsQuery->fetchAll(PDO::FETCH_ASSOC);
                    }

                } catch (Exception $exception) {
                    $errors['genericError'] = 'Unexpected application error';
                }
            }

            // based on previous if
            if (isset($shoplistItems)) {

                foreach ($shoplistItems as $listItem) {
                    echo
                        '<div class="card">
                            <div class="card-header flexRow cardContent">
                                <div>
                                    <span>'.htmlspecialchars($listItem['count']).'?? </span>
                                    <span>'.htmlspecialchars($listItem['name']).'</span>
                                </div>
                                <div>
                                    <a href="deleteListItem.php?itemId='.$listItem['id'].'&shopListId='.$listItem['shop_list_id'].'" class="btn btn-danger">X</a>
                                    
                                    <a href="editListItem.php?itemId='.$listItem['id'].'" class="btn btn-secondary">edit</a>
                                    <a href="markItemAsFinished.php?itemId='.$listItem['id'].'&shopListId='.$listItem['shop_list_id'].'" class="btn success">';
                                        if ($listItem['bought'] == false) {
                                            echo '&nbsp;&nbsp;&nbsp;';
                                        } else {
                                            echo '???';
                                        }
                            echo  '</a>
                                </div>
                            </div>
                        </div>';
                }
            }

            if ($shopListId != null) {
                //button for adding new item
                echo '<a href="editListItem.php?shopListId='.$shopListId.'" id="addListBtn" class="btn btn-secondary">Add new item</a><hr />';
            }



        ?>


<!-- error / info displaying-->
        <?php
            if (!empty($errors['genericError'])) { echo '<div class="alert alert-danger">'.$errors['genericError'].'</div>';  }
            if ($infoMessage != null) { echo '<div class="alert alert-info">'.$infoMessage.'</div>';  }
            $infoMessage = null;
        ?>


        <!-- submit buttons-->
        <input type="submit" class="btn btn-primary" name="saveShopListBtn" value="Save shopping list" />
        <a href="index.php" class="btn btn-light">Back</a>
    </form>


<?php
include 'inc/footer.php';
?>