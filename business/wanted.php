<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/catalog.css">
    <link href="../style/basic.css" rel="stylesheet">
    <title>Objets recherchés par les entreprises</title>
</head>

<body>
    <?php 
    include_once("../include_files/menu.php"); 
    include_once("../include_files/db_connection.php");

    $stmt = $db->prepare("SELECT Business.name AS entreprise ,BusinessBuy.quantity,BusinessBuy.price,TypeItem.name AS item,BusinessBuy.typeItem AS id FROM Business,BusinessBuy,TypeItem WHERE Business.id = BusinessBuy.business AND TypeItem.id = BusinessBuy.typeItem");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        extract($row);
        echo "<div class='article'>";
        echo "<div class='item'><h3>$item</h3></div>";
        echo "<div class='item'><img src='../uploaded_files/" . $id  . ".jpg' width='300'></div>";
        echo "<div class='item'><h4>$quantity produits recherchés par $entreprise à $price €</h4></div>";
        echo "<div class='item'><button value='" . $id . "' name='item' type='submit' class='button'>Voir</button></div>";
        echo "</div>";
    }
    ?>
</body>