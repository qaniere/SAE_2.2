<?php
    session_start();

    if(!isset($_SESSION["id"])) { //If not logged in
        header("Location: ../common/login.php");
        die();
    }

    if($_SESSION["account_type"] != "business") { //If not a business
        header("Location: " ."../index.php");
        die();
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
    <link rel="stylesheet" href="../style/dashboard.css">
</head>
<body>
    <?php include_once("../include_files/menu.php");?>
    <div id="content">         
        <h1>Tableau de bord</h1>
        <?php echo "<p>Vous êtes connecté au nom de l'entreprise <strong>" . $_SESSION["name"] . "</strong></p>"; ?>
        <p> Vos dernières ventes : </p>
        <table>
            <tr>
                <td><strong>Nom produit</produit></td>
                <td><strong>Quantités</produit></td>
                <td><strong>Client</produit></td>
                <td><strong>Date et heure</produit></td>
            </tr>
        </table>
        <h2>Actions</h2>
        <h3>Vendre un objet</h3>
        <ul>
            <li><a href="./sell_new_item.php">Ajouter un produit à vendre non présent dans le catalogue</a></li>
            <li><a href="./sell_catalog_item.php">Ajouter un produit à vendre déjà présent dans le catalogue</a></li>
        </ul>
        <h3>Rechercher un objet</h3>
        <ul>
            <li><a href="">Ajouter un produit recherché non présent dans le catalogue</a></li>
            <li><a href="">Ajouter un produit à vendre déjà présent dans le catalogue</a></li>
        </ul>
    </div>
</html>