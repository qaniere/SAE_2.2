<?php
    session_start();
    include_once("../include_files/db_connection.php");
    include_once("../include_files/menu.php");
    if (!isset($_SESSION['login'])) {
        header("Location: ../common/login.php");
    } else {
        
        foreach ($_SESSION['cart'] as $key => $value) {
            $stmt = $db->prepare("INSERT INTO CustomerOrder (CustomerID, ItemID, quantity) VALUES (?, ?, ?)");
            $stmt ->bind_param("iii", $_SESSION['id'], $key, $value);
            $stmt ->execute();

            $stmt = $db->prepare("UPDATE BusinessSell SET Quantity = Quantity - ? WHERE typeItem = ?");
            $stmt ->bind_param("ii", $value, $key);
            $stmt ->execute();
        }
    }
?>

<h1>Votre commande a été passée </h1>
<p> Merci d'avoir commandé chez nous, à la prochaine ! </p>