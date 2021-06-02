<form method="post" action="">
    <span>Select languages</span><br/>
    <input type="checkbox" name='lang[]' value="PHP"> PHP <br/>
    <input type="checkbox" name='lang[]' value="JavaScript"> JavaScript <br/>
    <input type="checkbox" name='lang[]' value="jQuery"> jQuery <br/>
    <input type="checkbox" name='lang[]' value="Angular JS"> Angular JS <br/>

    <input type="submit" value="Submit" name="submit">
</form>

<?php
if(isset($_POST['submit'])){

    if(!empty($_POST['lang'])) {

        foreach($_POST['lang'] as $value){
            echo "value : ".$value.'<br/>';
        }

    }

}
?>