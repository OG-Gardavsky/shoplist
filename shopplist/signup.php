<?php

    if (!empty($_POST)) {

        echo @$_POST['email'];
        echo @$_POST['password'];
        echo @$_POST['passwordCheck'];

    }



    $pageTitle='Register';
    include 'inc/header.php';
?>

<form method="post">
    <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required class="form-control
            value="<?php echo htmlspecialchars(@$_POST['email'])?>
        />

    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required class="form-control " />
    </div>

    <div class="form-group">
        <label for="passwordCheck">Re-enter password:</label>
        <input type="password" name="passwordCheck" id="passwordCheck" required class="form-control " />
    </div>

    <button type="submit" class="btn btn-primary">Sig up</button>
    <a href="login.php" class="btn btn-light">Back to Log in</a>
</form>


<?php
include 'inc/footer.php';
?>
