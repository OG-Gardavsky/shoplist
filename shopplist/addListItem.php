<?php
    $maxNameCharLength = 50;

    require 'inc/db.php';
    require 'user_required.php';

    $pageTitle='Add new item to list';
    include 'inc/header.php';

    $errors = [];

    $itemId = !empty($_REQUEST['itemId'])?$_REQUEST['itemId']:null;
    $shopListId = !empty($_REQUEST['shopListId'])?intval($_REQUEST['shopListId']):null;


    if ($itemId == null && $shopListId == null) {
        $errors['genericError'] = 'Not clear with which shopplist should be item asociated';
    } else if ($itemId != null && $shopListId != null) {
        $errors['genericError'] = 'cannot have itemId and shopListId parameter at the same time';
    }


    //reaction for save button
    if(isset($_POST['SaveItemBtn']) && empty($errors)) {
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
                $nameOfItem = $_POST['nameOfItem'];
                $countOfItem = $_POST['countOfItem'];

                //insert of new record
                if ($itemId == null && $shopListId != null) {

                    $saveQuery=$db->prepare('INSERT INTO sl_items (shop_list_id, name, count) VALUES (:shopListId, :nameOfItem, :countOfItem);');
                    try {
                        $saveQuery->execute([
                            ':shopListId'=> $shopListId,
                            ':nameOfItem'=> $nameOfItem,
                            ':countOfItem'=>$countOfItem
                        ]);

                        header('location: editShopList.php?shopListId='.$shopListId);

                    } catch (Exception $exception) {
                        $errors['genericError'] = 'Error during saving of shop list';
                    }
                }
            }

        }
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

        <?php
            if (!empty($errors['genericError'])) {
                echo '<div class="alert alert-danger">' . $errors['genericError'] . '</div>';
            }
        ?>

        <input type="submit" class="btn btn-primary" name="SaveItemBtn" value="Save item" />
<!--        TODO hardcodovany  if else - pokud bude sholist id tak zpatky tam jinak na index-->
        <a href="editShopList.php?shopListId=<?php echo $shopListId?>" class="btn btn-light">Back</a>
    </form>






<?php
include 'inc/footer.php';
?>