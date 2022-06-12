<?php
session_start();
$messsage = "";

if(!isset($_SESSION["id"])) { 
    header("Location: ../common/login.php");
    die();
}

if($_SESSION["account_type"] != "business") { 
    header("Location: " ."../index.php");
    die();
}

if(isset($_POST["item_id"]) && isset($_POST["price"]) && isset($_POST["quantity"])) {

    if($_POST["price"] <= 0) {
        $messsage = "Le prix doit être supérieur à 0";

    } else if($_POST["quantity"] <= 0) {
        $messsage = "La quantité doit être supérieur à 0";

    } else {
        include_once("../include_files/db_connection.php");

        $stmt = $db->prepare("UPDATE `BusinessSell` SET `business`=?,`typeItem`=?,`quantity`=?,`price`=? WHERE business = ? AND typeItem = ?");
        $stmt->bind_param("iiiiii", $_SESSION["id"], $_POST["item_id"], $_POST["quantity"], $_POST["price"], $_SESSION["id"], $_POST["item_id"]);
        $stmt->execute();

        $messsage = "Offre modifiée avec succès";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des offres</title>
    <link rel="stylesheet" href="../style/basic.css">
    <link rel="stylesheet" href="../style/form.css">
    <link rel="stylesheet" href="../style/manage_items.css">
</head>
<body>
    <?php include_once("../include_files/menu.php");

    echo "<div id='content'>";
    if(!isset($_GET["item_id"])) { 

        echo "<h1>Vos offres</h1>";
        include_once("../include_files/db_connection.php");

        $stmt = $db->prepare("SELECT TypeItem.*, BusinessSell.*, COUNT(CustomerOrder.itemID) AS sales FROM TypeItem JOIN BusinessSell ON TypeItem.id = BusinessSell.typeItem JOIN CustomerOrder ON CustomerOrder.itemID = TypeItem.id WHERE BusinessSell.business = ? GROUP BY CustomerOrder.itemID");
        $stmt->bind_param("i", $_SESSION["id"]);
        $stmt->execute();

        $result = $stmt->get_result();

        echo "<table>";
        echo "<tr>";
        echo "<td><strong>Nom du produit</strong></td>";
        echo "<td><strong>Prix</strong></td>";
        echo "<td><strong>Quantité</strong></td>";
        echo "<td><strong>Nombre de ventes</strong></td>";
        echo "<td><strong>Action</strong></td>";
        echo "</tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["price"] . "€</td>";
            echo "<td>" . $row["quantity"] . "</td>";
            echo "<td>" . $row["sales"] . "</td>";
            echo "<td><a class='link'href='manage_items.php?item_id=" . $row["id"] . "'>Modifier</a></td>";
            echo "</div>";
        }

        echo $messsage;

    } else if(isset($_GET["item_id"])) { 
        include_once("../include_files/db_connection.php");

        $stmt = $db->prepare("SELECT TypeItem.*, BusinessSell.* FROM TypeItem JOIN BusinessSell ON TypeItem.id = BusinessSell.typeItem WHERE TypeItem.id = ?");
        $stmt->bind_param("i", $_GET["item_id"]);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo "<div id='form-container'>";
        echo "<form action='manage_items.php' method='post'>";
        echo "<h1>Modifier votre offre</h1>";

        echo "<input type='hidden' name='item_id' value='" . $_GET["item_id"] . "'>";


        echo "<div class='form-question'>";
        echo "<label for='price'><strong>Nom de l'objet</strong></label>";
        echo "<br>";
        echo "<span>" . $row["name"] . "</span>";
        echo "</div>";

        echo "<div class='form-question'>";
        echo "<label for='price'><strong>Prix</strong></label>";
        echo "<br>";
        echo "<input type='number' name='price' id='price' value='" . $row["price"] . "'>";
        echo "</div>";

        echo "<div class='form-question'>";
        echo "<label for='quantity'><strong>Quantité</strong></label>";
        echo "<br>";
        echo "<input type='number' name='quantity' id='quantity' value='" . $row["quantity"] . "'>";
        echo "</div>";

        echo "<div class='form-question'>";
        echo "<input type='submit' value='Modifier'>";
        echo "</div>";
        echo "</form>";
        echo "</div>";
    }
    ?>
    </div>
</body>
</html>