<?php
    session_start();
    include_once("../include_files/db_connection.php");
    include_once("../include_files/menu.php");
    if (!isset($_SESSION['login'])) {
        header("Location: ../common/login.php");
    } else {
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
    }
?>

<h1>Votre commande a été passée </h1>
<p> Merci d'avoir commandé chez nous, à la prochaine ! </p>