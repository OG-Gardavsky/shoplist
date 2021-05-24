<?php

if (!empty($_POST)) {
    $email = @$_POST['email'];
    $password = @$_POST['password'];

    echo $email;
    echo $password;

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    echo $passwordHash;

    @$_POST['email'] = null;
    @$_POST['password'] = null;

//    header('Location: index.php');


}

    $pageTitle='Log in';
    include 'inc/header.php';
?>

<form method="post">
    <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required class="form-control"
            value="<?php echo htmlspecialchars(@$_POST['email'])?>
        />

    </div>

    <div class="form-group">
        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password" required class="form-control " />
    </div>

    <button type="submit" class="btn btn-primary">Log in</button>
    <a href="signup.php" class="btn btn-light">Sign up</a>
</form>


<?php
    include 'inc/footer.php';
?>
