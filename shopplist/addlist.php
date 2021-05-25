<?php
require 'inc/db.php';

    if (!empty(@$_POST)) {
    //    echo  'jmeno :'.@$_POST['name'].'<br />';

    //    $cislo = 1;
    //    echo 'jmeno polozky:'.@$_POST[$cislo.'itemName'].'<br />';

    //    echo 'pocet :'.@$_POST['cisloPOlozky'].'<br />';


    }


    function displayRows($rowCount) {
        for ($i = 0; $i<$rowCount; $i++) {
            echo '<div class="flexRow" >';
            $itemNum = $i + 1;

            echo ' <div class="form-group">';
            echo '<label for="neco">'.$itemNum.'. item</label>';
            echo '<input type="text" name="'.$itemNum.'itemName" id="neco" required class="form-control" value="'
                .htmlspecialchars(@$_POST[$itemNum.'itemName']).'"/>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label for="name">count</label>';
            echo '<input type="number" name="'.$itemNum.'itemCount" id="name" required class="form-control" value="'
                .htmlspecialchars(@$_POST[$itemNum.'itemCount']).'"/>';
            echo '</div>';

            echo '</div>';
        }
    }


    $pageTitle='Add new list';
    include 'inc/header.php';

?>

    <form method="post">
        <div class="form-group">
            <label for="name">Name of list</label>
            <input type="text" name="nameOfList" id="name" required class="form-control"
                value="<?php echo htmlspecialchars(@$_POST['nameOfList']) ?>"
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


            if (empty(@$_POST['numberOfRows'])) {
                @$_POST['numberOfRows'] = 1;
            }

            echo @$_POST['numberOfRows'];

            displayRows(@$_POST['numberOfRows']);

        ?>

<!--        <button id="addRowBtn" class="btn btn-secondary" onclick=" --><?php // @$_POST['numberOfRows'] ++ ?><!-- ">add item</button>-->
<!--        <button id="addRowBtn" class="btn btn-secondary" onclick=" --><?php // echo '<h1>blby toto</h1>' ?><!-- ">add item</button>-->


        <?php

        if(isset($_POST['button1'])) {
            echo "This is Button1 that is selected";
        }
        if(isset($_POST['button2'])) {
            echo "This is Button2 that is selected";
        }
        ?>

        <form method="post">
            <input type="submit" name="button1"
                   value="Button1"/>

            <input type="submit" name="button2"
                   value="Button2"/>
        </form>


        <hr />




        <button type="submit" class="btn btn-primary">Add shopping list</button>
        <a href="index.php" class="btn btn-light">cancel</a>
    </form>

<!--<script>-->
<!--    // document.querySelector('#addRowBtn').addEventListener('click', e => e.preventDefault());-->
<!--</script>-->

<?php
include 'inc/footer.php';
?>