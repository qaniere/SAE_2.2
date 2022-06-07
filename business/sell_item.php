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

    if(isset($_POST["item_name"]) && isset($_POST["specs"]) && isset($_POST["price"]) && isset($_POST["quantity"]) && isset($_FILES["image"])) {
    //Form is complete

        include_once("../include_files/db_connection.php");
        extract($_POST);

        $stmt = $db->prepare("SELECT * FROM TypeItem WHERE name = ?");
        $stmt->bind_param("s", $item_name);
        $stmt->execute();

        $result = $stmt ->get_result() ->fetch_assoc();

        if($result) {
            $message = "<strong>Cet objet existe déjà dans le catalogue</strong>";

        } else {

            $specs_lines = explode("\n", $specs);
            $error = false;

            foreach($specs_lines as $line) {
                $specs_array = explode("=", $line);
                if(sizeof($specs_array) != 2) {
                    $error = true;
                    break;
                }
            }

            if($error) {
                $message = "<strong>Format des caractéristiques incorrect !</strong>";

            } else {

                //Insert the name in the first table and get an item id from the databse
                $stmt = $db->prepare("INSERT INTO TypeItem (name) VALUES (?)");
                $stmt->bind_param("s", $item_name);
                $stmt->execute();

                $item_id = $stmt->insert_id;

                //Insert the spec into the second table
                $stmt = $db->prepare("INSERT INTO TypeItemDetails (typeItem, attribute, value) VALUES (?, ?, ?)");

                foreach($specs_lines as $line) {
                    $specs_array = explode("=", $line);
                    $stmt->bind_param("iss", $item_id, $specs_array[0], $specs_array[1]);
                    $stmt->execute();
                }

                //Insert the offer in the third table
                $stmt = $db->prepare("INSERT INTO BusinessSell (business, typeItem, price, quantity) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiii", $id, $item_id, $price, $quantity);
                $stmt->execute();

                //Get the file exentension of the image
                $array = explode(".", $_FILES["image"]["name"]);
                $file_extension = end($array);

                //Set paths
                $upload_directory = "../catalog_pictures/";
                $file = $upload_directory . $item_id . "." . $file_extension;

                //Create the upload dir if it doesn't exist
                if(!is_dir($upload_directory)) {
                    mkdir($upload_directory);
                }

                //Move the file to the upload directory
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $file)) {
                    $message = "<strong>Objet ajouté au catalogue</strong>";

                } else {
                    $message = "<strong>Erreur lors de l'ajout de l'objet au catalogue</strong>";
                }
            }
        }      
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
                <input type="text" name="item_name" id="item_name" required>
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
            <?php
                echo $message;
            ?>
        </form>
    </div>
</body>
</html>
