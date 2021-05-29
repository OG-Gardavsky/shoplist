<?php
    require 'inc/db.php';

    require 'user_required.php';



    $shopListsQuery = $db->prepare("SELECT sl_shop_lists.id, sl_shop_lists.name AS 'listName', sl_shop_lists.finished, sl_shop_lists.user_id, sl_categories.name AS 'categoryName' FROM sl_shop_lists JOIN sl_categories ON sl_shop_lists.category_id=sl_categories.id WHERE sl_shop_lists.user_id = ?");
    try {
        $shopListsQuery->execute([$currentUserId]);
        $shopLists = $shopListsQuery->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $exception) {
        $errors['genericError'] = 'Unexpected application error';
    }


    $pageTitle='';
    include 'inc/header.php';


?>

    <a href="addlist.php" class="btn btn-primary">Add new shopping list</a>

    <?php
        foreach ($shopLists as $shopList) {
            echo
            '<div class="card">
                <div class="card-header flexRow cardContent">
                    <div>
                        <span class="badge badge-info">'.htmlspecialchars($shopList['categoryName']).'</span>
                        <span>'.htmlspecialchars($shopList['listName']).'</span>
                    </div>
                    <div>
                        <a href="#" class="btn btn-secondary">edit</a>
                        <a type="button" class="btn btn-success">✓</a>
                    </div>
                </div>
            </div>';

        }
    ?>

<!--    <div class="card">-->
<!--        <div class="card-header flexRow cardContent">-->
<!--            <div>-->
<!--                <span class="badge badge-info">zradlo</span>-->
<!--                <span>some shooping list</span>-->
<!--            </div>-->
<!---->
<!--            <div>-->
<!--                <a href="#" class="btn btn-secondary">edit</a>-->
<!--                <a type="button" class="btn btn-success">✓</a>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--    </div>-->



<?php
    include 'inc/footer.php';
?>