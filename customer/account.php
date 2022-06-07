<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre compte</title>
    <link href="../style/basic.css" rel="stylesheet">
</head>
<body>
    <?php include_once("../include_files/menu.php");?>
    <h1>Votre compte</h1>
    <?php        
        if(isset($_SESSION["id"])) {

            include_once("../include_files/db_connection.php");
            
            //Select stash and username
            $stmt = $db -> prepare("SELECT stash FROM Customer WHERE id = ?");
            $stmt -> bind_param("i", $_SESSION["id"]);
            $stmt -> execute();

            $result = $stmt ->get_result();
            $row = $result ->fetch_assoc();

            $login = $_SESSION["login"];
            $cagnotte = $row["stash"];

            echo "Nom d'utilisateur : $login <br>Cagnotte fidélité : $cagnotte <br><br>";

            //Get all elements extracted by the customer
            $stmt = $db -> prepare("SELECT name, quantity FROM Mendeleiev, CustomerExtraction WHERE Customer = ? AND Z = element");
            $stmt -> bind_param("i", $_SESSION["id"]);
            $stmt -> execute();

            $result = $stmt -> get_result();
            while ($row = $result -> fetch_assoc()) {

                $element = $row["name"];
                $quantity = $row["quantity"];
                echo "$element : $quantity<br>";
            }
            
            echo "<h3>Historique des achats</h3>";
            $stmt = $db->prepare("SELECT TypeItem.name AS itemName, Business.name AS businessName, CustomerOrder.quantity, price FROM CustomerOrder JOIN BusinessSell ON CustomerOrder.businessID = BusinessSell.business AND CustomerOrder.itemID = BusinessSell.typeItem JOIN Business ON CustomerOrder.businessID = Business.id JOIN TypeItem ON CustomerOrder.itemID = TypeItem.id WHERE CustomerID = ?");
            $stmt->bind_param("i", $_SESSION["id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $itemID = $row["itemName"];
                $businessID = $row["businessName"];
                $quantity = $row["quantity"];
                $price = $row["price"]*$quantity;
                echo "Produit : $itemID, Business : $businessID, Quantité : $quantity, Prix : $price €<br>";
            }

        } else {
            echo "Vous n'êtes pas connecté. Allez sur <a href='login.php'>login.php</a>.";
        }
    ?>
</body>
</html>