<!DOCTYPE html>
<html lang="cs">
    <head>
        <title><?php echo (!empty($pageTitle)?$pageTitle.' - ':'')?>Shop list</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="inc/style.css">
        <link rel="shortcut icon" type="image/jpg" href="inc/favico.png"/>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <header class="container bg-dark">
            <a href="index.php" class="flexRow">
                <span> <img src="inc/favico.png" alt="logo" width="40" class="logo"/> </span>
                <h1 class="text-white py-4 px-2">Shop list</h1>
            </a>
            <?php
                $current_file_name = basename($_SERVER['PHP_SELF']);

                if ($current_file_name != "login.php" && $current_file_name != "signup.php") {

                    echo '<span> <a href="logout.php" class="btn btn-light">Log out</a> </span>';
                }

            ?>
        </header>
        <main class="container pt-2 main">
        <?php
            if (!empty($pageTitle)) {
                echo '<h2>'.$pageTitle.'</h2>';
            }
        ?>
        <hr />