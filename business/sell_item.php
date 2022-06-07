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

    // var_dump($_POST);
    // echo "<br> <br> <br> <br> <br>";
    // var_dump($_FILES);

    // echo "<br> <br> <br> <br> <br>";
    if(isset($_POST["item-name"]) && isset($_POST["specs"]) && isset($_POST["price"]) && isset($_POST["quantity"]) && isset($_FILES["image"])) {
    //Form is complete

        extract($_POST);

        //Check if item doest no exist

        //Insert into "Items"

        // $specs_lines = explode("\n", $specs);
        // foreach($specs_lines as $line) {
        //     echo $line;
        //     echo "<br>";
        // }
    }

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
            <h1 id="form-title">Ajouter un objet à vendre</h1>
            <div class="form-question">
                <label for="item-name"><strong>Nom de l'objet</strong></label>
                <br>
                <input type="text" name="item-name" id="item-name" required>
            </div>
            <div class="form-question">
                <label for="specs"><strong>Caractéristiques</strong></label>
                <br>
                <!-- &#10; means \n in html -->
                <textarea name="specs" id="specs" cols="45" rows="3" required placeholder="Attention à respecter la structure suivante :&#10;Caméra=30 mégapixels&#10;Stockage=128 GB"></textarea>
            </div>
            <div class="form-question">
                <label for="price"><strong>Prix</strong></label>
                <br>
                <input type="number" name="price" id="price" required>
            </div>
            <div class="form-question">
                <label for="quantity"><strong>Quantité</strong></label>
                <br>
                <input type="number" name="quantity" id="quantity" required>
            </div>
            <div class="form-question">
                <label for="image"><strong>Photo de l'objet</strong></label>
                <br>
                <input type="file" name="image" id="image" required>
            </div>
            <div class="form-question">
                <input type="submit" value="Ajouter">
            </div>
        </form>
    </div>
</body>
</html>
