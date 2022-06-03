<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
    <link rel="stylesheet" href="../style/basic.css">
</head>
<body>
    <?php include_once("../include_files/menu.php"); ?>
    <h1>Déconnexion réussie</h1>
    <p>Vous avez été déconnecté avec succès !</p>
    <a href="../index.php">
        <button>Retour à la page d'accueil</button>
    </a>
</body>
</html>