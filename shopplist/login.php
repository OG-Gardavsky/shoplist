<?php
    session_start();

    require 'inc/db.php';

    //if session exists redirects to homepage
    if(isset($_SESSION["user_id"])){
        header('Location: index.php');
    }

    $errors=[];

    if (!empty($_POST)) {

        // check if required values are filled in
        $requiredValues = ['email', 'password'];
        foreach ($requiredValues as $value) {
            if (empty(@$_POST[$value])) {
                $errors[$value] = 'Please fill '.$value;
            }
        }

        if (empty($errors)) {

            $email = @$_POST['email'];
            $password = @$_POST['password'];

            $existingUser = null;

            try {
                $stmt = $db->prepare("SELECT * FROM sl_users WHERE email = ? LIMIT 1");
                $stmt->execute([$email]);
                $existingUser=$stmt->fetch(PDO::FETCH_ASSOC);

            } catch (Exception $exception) {
                $errors['genericError'] = 'Unexpected application error';
            }


            if ($existingUser && password_verify($password, @$existingUser['password'])){
                $_SESSION['user_id'] = $existingUser['id'];
                header('Location: index.php');
            }else{
                $errors['genericErrors']="Invalid user or password!";
            }

            if (empty($errors)) {
                header('Location: index.php');
            }


        }



    }

    $pageTitle='Log in';
    include 'inc/header.php';
?>

<form method="post">
    <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required class="form-control <?php echo (!empty($errors['email'])?'is-invalid':''); ?>"
               value="<?php echo htmlspecialchars(@$_POST['email']); ?>" />
        <?php
            if (!empty($errors['email'])){
                echo '<div class="invalid-feedback">'.$errors['email'].'</div>';
            }
        ?>
    </div>

    <div class="form-group">
        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password" required class="form-control <?php echo (!empty($errors['password'])?'is-invalid':''); ?>" />
        <?php
            if (!empty($errors['password'])){
                echo '<div class="invalid-feedback">'.$errors['password'].'</div>';
            }
        ?>
    </div>

    <?php if (!empty($errors)) { echo '<div class="alert alert-danger"> Unable to login. </div>';  } ?>

    <button type="submit" class="btn btn-primary">Log in</button>
    <a href="signup.php" class="btn btn-light">Sign up</a>
</form>


<?php
    include 'inc/footer.php';
?>
