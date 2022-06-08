<?php
    session_start();
?>
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
    include_once("../include_files/menu.php");
    include_once("../include_files/db_connection.php");
    $total = 0;

    //Verify if there is items in the cart
    if (isset($_SESSION['cart'])) {

        //Foreach loop to go through all items
        foreach ($_SESSION["cart"] as $id => $businessID) {

            //Foreach loop to go through all business the item is sold by
            foreach ($businessID as $quantity) {
                
                //Get the businessID as an index not an array
                $bID =  array_search($quantity, $businessID);

                $stmt = $db -> prepare("SELECT name, price, quantity, file_extension FROM TypeItem JOIN BusinessSell ON BusinessSell.typeItem = TypeItem.id WHERE id = ? AND BusinessSell.business = ?");
                $stmt -> bind_param("ii",$id,$bID);
                $stmt -> execute();
                $result = $stmt -> get_result();
                $row = $result -> fetch_assoc();

                echo "<img src='../catalog_pictures/" . $id . "." .  $row["file_extension"] . "' width='300'><br>";
                echo $row["name"];

?>
            
            <form action="../customer/update_cart.php" method="POST">
                <input type="number" name="quantity" min=0 max=<?=$row['quantity']?> value="<?=$quantity?>">
                <input type="hidden" name="productID" value="<?=$id?>">
                <input type="hidden" name="businessID" value="<?=$bID?>">
                <input type="submit" value="Modifier">
            </form>

<?php
            
            echo "Prix : " . $row["price"] * $quantity . "€";
            $total += $row["price"] * $quantity;

?>
    
    <form action="../customer/remove_from_cart.php" method="post">
        <input type="hidden" name="productID" value=<?=$id?>>
        <input type="hidden" name="businessID" value=<?=$bID?>>
        <button type="submit"> 🗑️ Retirer du panier</button>
    </form>

<?php
            }
        }
    //Else echo that the cart is empty
    } else {
        
        echo "Votre panier est vide";

    }
?>

<br>
<h2>Total : <?=$total?>€ </h2>
<form action="../customer/checkout.php" method="post">
    <button type="submit">Passer la commande</button>
</form>