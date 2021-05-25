<?php
require 'inc/db.php';

if (!empty(@$_POST)) {
//    echo  'jmeno :'.@$_POST['name'].'<br />';
//    echo 'jmeno polozky:'.@$_POST['jmenoPolozky'].'<br />';
//    echo 'pocet :'.@$_POST['cisloPOlozky'].'<br />';


}


$pageTitle='Add new list';
include 'inc/header.php';

?>

    <form method="post">
        <div class="form-group">
            <label for="name">Name of list</label>
            <input type="text" name="nameOfList" id="name" required class="form-control"
                value=" <?php echo htmlspecialchars(@$_POST['nameOfList']) ?> "
            />
        </div>


        <div class="flexRow">

            <div class="dropdown" >
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                    Category of shoplist
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Link 1</a>
                    <a class="dropdown-item" href="#">Link 2</a>
                    <a class="dropdown-item" href="#">Link 3</a>
                </div>
            </div>

            <a href="addcategory.php" class="btn btn-light">add new Category</a>
        </div>

        <hr />


        <?php
            $initialNum = 1;

            //udelat funkci ktera bude pri zvetseni cisla itereaci o i prekreslova celej seznam

            for ($i = 0; $i<1; $i++) {
                echo '<div class="flexRow" >';
                $itemNum = $i + 1;

                echo ' <div class="form-group">';
                echo '<label for="neco">'.$itemNum.'. item</label>';
                echo '<input type="text" name="itemName" id="neco" required class="form-control" value="'
                    .htmlspecialchars(@$_POST['itemName']).'"/>';
                echo '</div>';

                echo '<div class="form-group">';
                echo '<label for="name">count</label>';
                echo '<input type="number" name="itemCount" id="name" required class="form-control" value="'
                    .htmlspecialchars(@$_POST['itemCount']).'"/>';
                echo '</div>';

                echo '</div>';
            }

        ?>




        <button type="submit" class="btn btn-primary">Add shopping list</button>
        <a href="index.php" class="btn btn-light">cancel</a>
    </form>


<?php
include 'inc/footer.php';
?>