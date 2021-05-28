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
    </head>
    <body>
        <header class="container bg-dark">
            <a href="index.php">
                <h1 class="text-white py-4 px-2">Shop list</h1>
            </a>
            <span> <a href="logout.php" class="btn btn-light">Log out</a> </span>
        </header>
        <main class="container pt-2">
        <h2><?php echo (!empty($pageTitle) ? $pageTitle : '')?></h2>