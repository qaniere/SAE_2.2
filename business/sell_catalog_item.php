<?php
    session_start();
    $message = "";

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
    <title>Ajouter un objet à vendre</title>
    <link rel="stylesheet" href="../style/basic.css">
    <link rel="stylesheet" href="../style/form.css">
</head>
<body>
    <?php include_once("../include_files/menu.php");?>
    <div id="form-container">
        <form action="sell_item.php" method="post" enctype="multipart/form-data">
            <h1 id="form-title">Ajouter objet du catalogue à vendre</h1>
            <p>
                Cette page vous permet de vendre un produit qui est déjà présent dans le catalogue. 
                Si votre objet n'est pas présent dans le catalogue, utilisez <a href="sell_new_item.php">cette page</a>
            </p>
            <div class="form-question">
                <label for="item-name"><strong>Nom de l'objet</strong></label>
                <br>
                <input type="text" name="item_name" id="item_name" required>
            </div>
            <div class="form-question">
                <input type="submit" value="Rechercher">
            </div>
            <?php
                echo $message;
            ?>
        </form>
    </div>
</body>
</html>
