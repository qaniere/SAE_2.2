<?php
session_start();
        
if(!isset($_SESSION['login'])) {
    header("Location: ../common/login.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande passée !</title>
    <link rel="stylesheet" href="../style/basic.css">
</head>
<body>
    <?php
            include_once("../include_files/db_connection.php");
            include_once("../include_files/menu.php");

            //Select all items in the cart and update the database
            foreach ($_SESSION['cart'] as $id => $businessID) {
                foreach ($businessID as $quantity) {
                    $bID =  array_search($quantity, $businessID);
                    $stmt = $db->prepare("INSERT INTO CustomerOrder (CustomerID, ItemID, BusinessID, quantity) VALUES (?, ?, ?, ?)");
                    $stmt ->bind_param("iiii", $_SESSION['id'], $id, $bID, $quantity);
                    $stmt ->execute();

                    $stmt = $db->prepare("UPDATE BusinessSell SET quantity = quantity - ? WHERE typeItem = ? AND business = ?");
                    $stmt ->bind_param("iii", $quantity, $id, $bID);
                    $stmt ->execute();
                }
                
            }

            //Empty the cart
            unset($_SESSION['cart']);
            ?>
            <h1>Votre commande a été passée </h1>
            <p> Merci d'avoir commandé chez nous, à la prochaine ! </p>
</body>
</html>