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
    <link rel="stylesheet" href="../style/404.css">
    <title>Erreur 404</title>
</head>
<body>
    <?php include_once("../include_files/menu.php");?>
    <div id="page-content">
        <div class="text-container">
            <h1>Erreur 404</h1>
        </div> 
        <div class="text-container">
            <p>La page demandée n'existe pas !</p>
        </div>     
        <div class="text-container">           
            <a href="../index.php">Retourner à l'accueil</a>
        </div>      
    </div>
</body>
