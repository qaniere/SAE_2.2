<?php
session_start();
session_destroy();
$logout = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
    <link rel="stylesheet" href="../style/basic.css">
    <link rel="stylesheet" href="../style/404.css">
</head>
<body>
    <?php include_once("../include_files/menu.php");?>
    <div id="page-content">
        <div class="text-container">
            <h1>Déconnexion réussie.</h1>
        </div> 
        <div class="text-container">
            <p>Vous avez été déconnecté avec succès.</p>
        </div>     
        <div class="text-container">           
            <a href="../index.php">Retourner à l'accueil</a>
        </div>      
    </div>
</body>
</html>