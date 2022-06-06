<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/basic.css">
    <title>Erreur 404</title>
</head>
<body>
    <?php include_once("../include_files/menu.php");?>

        <h1>Erreur 404</h1>
        <p>La page demandée n'existe pas !</p>
        <a href="../index.php">Retourner à l'accueil</a>
</body>
