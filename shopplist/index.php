<?php
    require 'inc/db.php';



//    $query = $db->prepare('SELECT * FROM sl_users');
//    $query->execute();
//
//    $posts = $query->fetchAll(PDO::FETCH_ASSOC);
//
//    foreach ($posts as $post) {
//        echo htmlspecialchars($post['email']).'<br/>' ;
//    }


    $pageTitle='';
    include 'inc/header.php';

    ?>

    <h1>
        your shopping lists
    </h1>

    <a href="addlist.php" class="btn btn-primary">Add new shopping list</a>


<?php
    include 'inc/footer.php';
?>