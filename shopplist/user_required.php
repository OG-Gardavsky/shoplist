<?php

	session_start();

	if(!isset($_SESSION["user_id"])){
		header('Location: login.php');
		die();
	}

	$stmt = $db->prepare("SELECT * FROM sl_users WHERE id = ? LIMIT 1");
	$stmt->execute(array($_SESSION["user_id"]));

	$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentUserId = $_SESSION["user_id"];

    if (!$currentUser){
        session_destroy();
        header('Location: index.php');
        die();
    }
