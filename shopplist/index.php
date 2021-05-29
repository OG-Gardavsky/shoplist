<?php
    require 'inc/db.php';

    require 'user_required.php';



    $shopListsQuery = $db->prepare("SELECT * FROM sl_shop_lists WHERE user_id = ?");
    try {
        $shopListsQuery->execute([$currentUserId]);
        $shopLists = $shopListsQuery->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $exception) {
        $errors['genericError'] = 'Unexpected application error';
    }


    $pageTitle='';
    include 'inc/header.php';


?>

<!--    <h1>your shopping lists</h1>-->

    <a href="addlist.php" class="btn btn-primary">Add new shopping list</a>

    <?php
        foreach ($shopLists as $shopList) {
//            echo '';
//                echo '';
//                echo '';
//            echo '';

        }
    ?>

    <div class="card">
        <div class="card-header">
            <div><span class="badge badge-info">zradlo</span></div>
            some shooping list
        </div>
        <div class="card-body flexRow cardContent">
<!--            <div><span class="badge badge-secondary">'.htmlspecialchars($post['category_name']).'</span></div>-->
            <div><span class="badge badge-secondary">zradlo</span></div>
            <span>category: jidlo</span>

            <div>
                <a href="#" class="btn btn-secondary">edit</a>
                <a type="button" class="btn btn-success">✓</a>
            </div>
        </div>
    </div>




<?php
    include 'inc/footer.php';
?>