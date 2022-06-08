<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre panier - Coff-IT</title>
    <link rel="stylesheet" href="../style/basic.css">
</head>
<body>
    
<?php
    session_start();
    include_once("../include_files/menu.php");
    include_once("../include_files/db_connection.php");
    $total = 0;

    //Select all items in the cart
    foreach ($_SESSION["cart"] as $id => $businessID) {
        foreach ($businessID as $nbArticles) {
            echo "<img src='../uploaded_files/" . $id . ".jpg' height='400'><br>";
            $stmt = $db -> prepare("SELECT name, price, quantity FROM TypeItem JOIN BusinessSell ON BusinessSell.typeItem = TypeItem.id WHERE id = ?");
            $stmt -> bind_param("i",$id);
            $stmt -> execute();
            $result = $stmt -> get_result();
            $row = $result -> fetch_assoc();
            echo $row["name"];
?>
        <form action="../common/update_cart.php" method="POST">
            <input type="number" name="quantity" min=0 max=<?=$row['quantity']?> value="<?=$nbArticles?>">
            <input type="hidden" name="productID" value="<?=$id?>">
            <input type="hidden" name="businessID" value="<?=$businessID?>">
            <input type="submit" value="Modifier">
        </form>
<?php
        echo "Prix : " . $row["price"] * $nbArticles . "€";
        $total += $row["price"] * $nbArticles;

?>
<form action="../common/remove_from_cart.php" method="post">
    <input type="hidden" name="productID" value=<?=$id?>>
    <button type="submit"> 🗑️ Retirer du panier</button>
</form>

<?php
        }
    }
?>
<br>
<h2>Total : <?=$total?>€ </h2>
<form action="../common/checkout.php" method="post">
    <button type="submit">Passer la commande</button>
</form>