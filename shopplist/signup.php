<?php

    require 'inc/db.php';

    $errors=[];

    if (!empty(@$_POST)) {

        // check if required values are filled in
        $requiredValues = ['email', 'password', 'passwordCheck'];
        foreach ($requiredValues as $value) {
            if (empty(@$_POST[$value])) {
                $errors[$value] = 'Please fill '.$value;
            }
        }

        if (empty($errors)) {
            $email = @$_POST['email'];
            $password = @$_POST['password'];
            $passwordCheck = @$_POST['passwordCheck'];

            if ($passwordCheck != $password) {
                $errors['password'] = 'passwords have to match';
                $errors['passwordCheck'] = 'passwords have to match';
            }

            try {
                $isEmailTaken = $db->prepare("SELECT * FROM sl_users where email = ? LIMIT 1");
                $isEmailTaken->execute([$email]);
                if (intval($isEmailTaken->rowCount()) != 0){
                    $errors['email'] = 'email is already taken';
                }
            } catch (Exception $exception) {
                $errors['genericError'] = 'unexpected application error';
            }






            if (empty($errors)) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $insertUser = $db->prepare("INSERT INTO sl_users(email, password) VALUES (?, ?)");
                $insertUser->execute([$email, $passwordHash]);

//                header('Location: index.php');
                echo 'hezky';
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

    <?php if (!empty($errors['genericError'])) { echo '<div class="alert alert-danger">'.$errors['genericError'].'</div>';  } ?>


    <button type="submit" class="btn btn-primary">Sig up</button>
    <a href="login.php" class="btn btn-light">Back to Log in</a>
</form>


<?php
include 'inc/footer.php';
?>
