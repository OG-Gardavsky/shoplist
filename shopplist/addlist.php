<?php

    require 'inc/db.php';
    require 'user_required.php';


    $errors=[];
    $selectedCategory=(!empty($_POST['categoryId'])?intval($_POST['categoryId']):'');

    //action for save button
    if(isset($_POST['saveShopListBtn'])) {

        if ($_POST['nameOfList'] == '' || $_POST['nameOfList'] == null ) {
            $errors['nameOfList'] = 'name cannot be blank';
        }

        if ($_POST['categoryId'] == '' || $_POST['categoryId'] == null ) {
            $errors['categoryId'] = 'category cannot be blank';
        }

        if (empty($errors)) {
            $nameOfList = trim($_POST['nameOfList']);
            $categoryId = $_POST['categoryId'];

            $saveQuery=$db->prepare('INSERT INTO sl_shop_lists (user_id, category_id, name) VALUES (:user, :categoryId, :name);');
            try {
                $saveQuery->execute([
                    ':user'=> $currentUserId,
                    ':categoryId'=> $categoryId,
                    ':name'=>$nameOfList
                ]);

                header('location: index.php');

            } catch (Exception $exception) {
                $errors['genericError'] = 'Error during saving of shop list';
            }
        }
    }


    $categoryListQuery = $db->prepare("SELECT * FROM sl_categories WHERE user_id = ?");
    try {
        $categoryListQuery->execute([$currentUserId]);
        $categoryList = $categoryListQuery->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $exception) {
        $errors['genericError'] = 'Unexpected application error';
    }





    function displayRows($rowCount) {
        for ($i = 0; $i<$rowCount; $i++) {

            $itemNum = $i + 1;

            echo '<div class="flexRow" >';

//                echo '<input type="hidden" name="checked" value="false" />';
//
//                echo '<span> <button type="button" class="btn btn-success checkBtnPosition">';
//                if ($_POST['checked'] == true ) { echo '✓'; }
//                echo '</button> </span> ';


                echo '<span> <button type="button" class="btn btn-success checkBtnPosition">✓</button> </span> ';

                echo ' <div class="form-group">';
                    echo '<label for="neco">'.$itemNum.'. item</label>';
                    echo '<input type="text" name="'.$itemNum.'itemName" id="neco"  class="form-control" value="'
                    .htmlspecialchars(@$_POST[$itemNum.'itemName']).'"/>';
                echo '</div>';

                echo '<div class="form-group">';
                    echo '<label for="name">count</label>';
                    echo '<input type="number" name="'.$itemNum.'itemCount" id="name" class="form-control" value="'
                    .htmlspecialchars(@$_POST[$itemNum.'itemCount']).'"/>';
                echo '</div>';

                echo '<span> <button type="button" class="btn btn-danger delBtnPosition">X</button> </span> ';

            echo '</div>';
        }
    }


    $pageTitle='Add new list';
    include 'inc/header.php';

?>
<!-- List name -->
    <form method="post">
        <div class="form-group">
            <label for="name">Name of list</label>
            <input type="text" name="nameOfList" id="name" class="form-control <?php echo (!empty($errors['nameOfList'])?'is-invalid':''); ?>"

                value="<?php echo htmlspecialchars(@$_POST['nameOfList']) ?>"
            />
            <?php
                if (!empty($errors['nameOfList'])){
                    echo '<div class="invalid-feedback">'.$errors['nameOfList'].'</div>';
                }
            ?>
        </div>


<!-- category selection -->
        <div class="form-group">
            <label for="categoryId">Category:</label>
            <select name="categoryId"

                    class="form-control <?php echo (!empty($errors['categoryId'])?'is-invalid':''); ?>">
                <option value="">--choose category--</option>
                <?php
                    if (!empty($categoryList)){
                        foreach ($categoryList as $category){

                            echo '<option value="'.$category['id'].'"'
                                .($category['id']==$selectedCategory?'selected="selected"':'').'>'
                                .htmlspecialchars($category['name'])
                                .'</option>';
                        }
                    }
                ?>
            </select>
            <?php
                if (!empty($errors['categoryId'])){
                    echo '<div class="invalid-feedback">'.$errors['categoryId'].'</div>';
                }
            ?>
        </div>

        <span> <a href="addcategory.php" class="btn btn-light">add new Category</a> </span>
        <hr />


<!--displaying items -->
        <?php
            //logic for displaying
//            if ( empty($_POST['numberOfRows']) ) {
//                $_POST['numberOfRows'] = 1;
//            }
//
//            if(isset($_POST['addRowBtn'])) {
//                $_POST['numberOfRows'] = $_POST['numberOfRows'] + 1;
//            }
//
//            displayRows(@$_POST['numberOfRows']);

/*        <input type="hidden" name="numberOfRows" value="<?php echo $_POST['numberOfRows']?>" />*/
//        <input type="submit" class="btn btn-secondary" name="addRowBtn" value="Add item" />
//        <hr />


        ?>

<!-- submit buttons-->


        <?php if (!empty($errors['genericError'])) { echo '<div class="alert alert-danger">'.$errors['genericError'].'</div>';  } ?>


        <input type="submit" class="btn btn-primary" name="saveShopListBtn" value="Save shopping list" />
        <a href="index.php" class="btn btn-light">Back</a>
    </form>


<?php
include 'inc/footer.php';
?>