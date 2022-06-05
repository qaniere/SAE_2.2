<?php
    session_start();

    if(!isset($_SESSION["id"])) { //If not logged in
        header("Location: ../common/login.php");
        die();
    }

    if($_SESSION["account_type"] != "business") { //If not a business
        header("Location: " ."../index.php");
    }

    extract($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../style/basic.css">
</head>
<body>
    <?php include_once("../include_files/menu.php");?>
    <h1>Tableau de bord</h1>
    <?php echo "<p>Vous êtes connecté au nom de l'entreprise $business_name </p>"; ?>
    <a href="./add_item.php">Ajouter un produit</a>
</html>