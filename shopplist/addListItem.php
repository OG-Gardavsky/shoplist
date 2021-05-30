<?php
    $maxNameCharLength = 50;

    require 'inc/db.php';
    require 'user_required.php';

    $pageTitle='Add new item to list';
    include 'inc/header.php';

    $errors = [];

    $itemId = !empty($_REQUEST['itemId'])?$_REQUEST['itemId']:null;

    //TODO if to neni asociovany ani s listem ani to neni existujici zaznam => exception


    if(isset($_POST['SaveItemBtn'])) {
        //check of null
        if ($_POST['nameOfItem'] == '' || $_POST['nameOfItem'] == null ) {
            $errors['nameOfItem'] = 'Name of item cannot be blank';
        }

        if ($_POST['countOfItem'] == '' || $_POST['countOfItem'] == null ) {
            $errors['countOfItem'] = 'Count of item cannot be blank';
        }


        if (empty($errors)) {
            // check of correct data format
            if (intval($_POST['countOfItem']) < 0) {
                $errors['countOfItem'] = 'Count of item has to be positive number';
            }

            if (strlen($_POST['nameOfItem']) > $maxNameCharLength) {
                $errors['nameOfItem'] = 'Name of item has to be shorter than'.$maxNameCharLength.'characters';
            }

            // save when validations pass
            if (empty($errors)) {
                //insert of new record
                if ($shopListId == null) {

                    $saveQuery=$db->prepare('INSERT INTO sl_shop_lists (user_id, category_id, name) VALUES (:userId, :categoryId, :name);');
                    try {
                        $saveQuery->execute([
                            ':userId'=> $currentUserId,
                            ':categoryId'=> $categoryId,
                            ':name'=>$nameOfList
                        ]);

                        header('location: index.php');

                    } catch (Exception $exception) {
                        $errors['genericError'] = 'Error during saving of shop list';
                    }
                }
            }

        }
    }



    if (!empty($errors['genericError'])) {
        echo '<div class="alert alert-danger">' . $errors['genericError'] . '</div>';
    }


?>

    <form method="post">

        <div class="flexRow">

            <div class="form-group">
                <label for="neco">Count of item</label>
                <input type="text" name="nameOfItem"  class="form-control <?php echo (!empty($errors['nameOfItem'])?'is-invalid':''); ?>"

                       value="<?php echo htmlspecialchars(@$_POST['nameOfItem']) ?>" />
                <?php
                if (!empty($errors['nameOfItem'])){
                    echo '<div class="invalid-feedback">'.$errors['nameOfItem'].'</div>';
                }
                ?>
            </div>

            <div class="form-group">
                <label for="count of item">Count of item</label>
                <input type="number" name="countOfItem"  class="form-control <?php echo (!empty($errors['countOfItem'])?'is-invalid':''); ?>"

                       value="<?php echo htmlspecialchars(@$_POST['countOfItem']) ?>" />
                <?php
                    if (!empty($errors['countOfItem'])){
                        echo '<div class="invalid-feedback">'.$errors['countOfItem'].'</div>';
                    }
                ?>
            </div>


        </div>



        <input type="submit" class="btn btn-primary" name="SaveItemBtn" value="Save item" />
<!--        TODO hardcodovany  if else - pokud bude sholist id tak zpatky tam jinak na index-->
        <a href="editShopList.php?shopListId=31" class="btn btn-light">Back</a>
    </form>






<?php
include 'inc/footer.php';
?>