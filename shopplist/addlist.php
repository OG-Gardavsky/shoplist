<?php
require 'inc/db.php';



$pageTitle='Add new list';
include 'inc/header.php';

?>

    <form method="post">
        <div class="form-group">
            <label for="name">Name of list</label>
            <input type="text" name="name" id="name" required class="form-control" />
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


            for ($i = 0; $i<5; $i++) {
                echo '<div class="flexRow" >';

                echo ' <div class="form-group">';
                echo '<label for="name">'.$i.'. item</label>';
                echo '<input type="text" name="name" id="name" required class="form-control" />';
                echo '</div>';
                echo '<div class="form-group">';
                echo '<label for="name">count</label>';
                echo '<input type="number" name="name" id="name" required class="form-control" />';
                echo '</div>';

                echo '</div>';
            }

            echo '<div class="flexRow" >';

            echo ' <div class="form-group">';
            echo '<label for="name">1. item</label>';
            echo '<input type="text" name="name" id="name" required class="form-control" />';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="name">count</label>';
            echo '<input type="number" name="name" id="name" required class="form-control" />';
            echo '</div>';

            echo '</div>';

        ?>

        <div class="flexRow">

            <div class="form-group">
                <label for="name">1. item</label>
                <input type="text" name="name" id="name" required class="form-control" />
            </div>

            <div class="form-group">
                <label for="name">count</label>
                <input type="number" name="name" id="name" required class="form-control" />
            </div>

        </div>





        <button type="submit" class="btn btn-primary">Add shopping list</button>
        <a href="index.php" class="btn btn-light">cancel</a>
    </form>


<?php
include 'inc/footer.php';
?>