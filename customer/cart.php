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
    <link rel="stylesheet" href="../style/cart.css">
</head>
<body>
    <?php include_once("../include_files/menu.php"); ?>
    <div id="cart-container">
        <h1>Votre panier</h1>
        <?php
        include_once("../include_files/db_connection.php");
        
        //Verify if there is items in the cart
        if(isset($_SESSION["cart"])) {

            $total = 0;

            //Foreach loop to go through all items in the
            foreach ($_SESSION["cart"] as $id => $businessID) {

                //Foreach loop to go through all business the item is sold by
                foreach ($businessID as $quantity) {
                    
                    //Get the businessID as an index not an array
                    $bID =  array_search($quantity, $businessID);

                    $stmt = $db -> prepare("SELECT TypeItem.name, price, quantity, file_extension, Business.name AS Vendor FROM TypeItem JOIN BusinessSell ON BusinessSell.typeItem = TypeItem.id JOIN Business ON Business.id = BusinessSell.business WHERE TypeItem.id = ? AND Business.id = ?");
                    $stmt -> bind_param("ii", $id, $bID);
                    $stmt -> execute();
                    $result = $stmt -> get_result();
                    $row = $result -> fetch_assoc();

                    ?> 
                        <div class='cart-item'>
                            <form action="../customer/update_cart.php" method="POST">
                            <?php 
                                echo "<h2>" . $row["name"] . "</h2>";
                                echo "<img class='cart-image' src='../catalog_pictures/" . $id . "." .  $row["file_extension"] . "' width='300'><br>";
                                
                            ?>
                            <label for="quantity"><strong>Quantité :</strong></label>
                            <input type="number" name="quantity" min=0 max=<?=$row['quantity']?> value="<?=$quantity?>">
                            <input type="hidden" name="productID" value="<?=$id?>">
                            <input type="hidden" name="businessID" value="<?=$bID?>">
                            <input type="submit" value="Modifier la quantité">
                            <br>
                            <?php
                            
                            echo "<strong>Prix : </strong>" . $row["price"] * $quantity . "€";
                            echo "<br>";
                            echo "<strong>Vendeur : </strong>" . $row["Vendor"];
                            $total += $row["price"] * $quantity;
                            ?>
                            </form>    
                            <form action="../customer/remove_from_cart.php" method="post">
                                <input type="hidden" name="productID" value=<?=$id?>>
                                <input type="hidden" name="businessID" value=<?=$bID?>>
                                <button type="submit"> 🗑️ Retirer du panier</button>
                            </form>
                        </div>
                    <?php
                }
            }
        //Else echo that the cart is empty
        } else {
            echo "Votre panier est vide pour le moment.";

        }
        ?>
        <br>
        <?php 
        if(isset($total)) {
            echo "<h2 id='sum'>Total du panier: $total € </h2>";
            echo "<form action='../customer/checkout.php' method='post'>
                <button type='submit'>Passer la commande</button>
            </form>";
        }
        ?>
    </div>