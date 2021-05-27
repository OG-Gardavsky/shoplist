<?php

    require 'inc/db.php';

    $errors=[];

    if (!empty(@$_POST)) {

        $requiredValues = ['email', 'password', 'passwordCheck'];

        foreach ($requiredValues as $value) {
            if (empty(@$_POST[$value])) {
                $errors[$value] = 'Please fill '.$value;
            }
        }


    }



    $pageTitle='Register';
    include 'inc/header.php';
?>

<form method="post">
    <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required class="form-control <?php echo (!empty($errors['email'])?'is-invalid':''); ?>"
            value=" <?php echo htmlspecialchars(@$_POST['email']) ?>"
        />
        <?php
        if (!empty($errors['email'])){
            echo '<div class="invalid-feedback">'.$errors['email'].'</div>';
        }
        ?>
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required class="form-control <?php echo (!empty($errors['password'])?'is-invalid':''); ?>" />
        <?php
            if (!empty($errors['password'])){
                echo '<div class="invalid-feedback">'.$errors['password'].'</div>';
            }
        ?>
    </div>

    <div class="form-group">
        <label for="passwordCheck">Password:</label>
        <input type="password" name="passwordCheck" id="passwordCheck" required class="form-control <?php echo (!empty($errors['passwordCheck'])?'is-invalid':''); ?>" />
        <?php
        if (!empty($errors['passwordCheck'])){
            echo '<div class="invalid-feedback">'.$errors['passwordCheck'].'</div>';
        }
        ?>
    </div>

    <button type="submit" class="btn btn-primary">Sig up</button>
    <a href="login.php" class="btn btn-light">Back to Log in</a>
</form>


<?php
include 'inc/footer.php';
?>
