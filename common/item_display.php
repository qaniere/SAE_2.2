<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage d'un objet du catalog</title>
    <link href="../style/basic.css" rel="stylesheet">
    <link href="../style/item_display.css" rel="stylesheet">
</head>
<body>
    <?php
        include_once("../include_files/menu.php");

        echo "<div id='content'>";

        if (isset($_GET["item"])) {
            $id = $_GET["item"];

        } else {
            die("Aucun article séléctionné.");
        }

        include_once("../include_files/db_connection.php");

        //Check if the item exists
        $exists = $db->query("SELECT typeItem FROM BusinessSell WHERE typeItem = $id");
        $row = $exists->fetch_assoc();
        if (!isset($row["typeItem"])) {
            die("Cet article n'est pas en vente actuellement.<br><a href='./catalog.php'>Retourner au catalogue</a>");
        }

    //Get the item's name, his price, the quantity available and the vendors
        $stmt = $db -> prepare("SELECT TypeItem.name AS ItemName, TypeItem.file_extension, price, quantity, Business.name AS BusinessName FROM TypeItem,BusinessSell,Business WHERE TypeItem.id = ? AND TypeItem.id = typeItem AND Business.id = BusinessSell.business");
        $stmt -> bind_param("i",$id);
        $stmt -> execute();

        $result = $stmt -> get_result();
        $row = $result -> fetch_assoc();

        $file_extension = $row["file_extension"];
        $name = $row["ItemName"];
        $max_quantity = 0;
        $quantity = $row["quantity"];
        if ($quantity > $max_quantity) $max_quantity = $quantity; 

        //Item picture
        echo "<img id='item-picture' src='../catalog_pictures/" . $id . "." . $file_extension . "'>";
        echo "<br>";
        echo "<h1 id='item-name'>$name</h1>";

        //Display each attributes of the item.
        $stmt_specs = $db -> prepare("SELECT attribute,value FROM TypeItemDetails WHERE typeItem = ?");
        $stmt_specs -> bind_param("i",$id);
        $stmt_specs -> execute();

        $result_specs = $stmt_specs -> get_result();
        $row_specs = $result_specs -> fetch_assoc();

        echo "<h2>Caractéristiques</h2>";
        echo "<ul>";

        $attribute = $row_specs["attribute"];
        $value = $row_specs["value"];
        echo "<li>$attribute : $value</li>";

        while ($row_specs = $result_specs -> fetch_assoc()) {
            $attribute = $row_specs["attribute"];
            $value = $row_specs["value"];
            echo "<li>$attribute : $value</li>";
        }

        echo "</ul>";

        //Sellers
        echo "<h2>Vendeurs</h2>";
        echo "<ul>";
        $business = $row["BusinessName"];
        $price = $row["price"];
        echo "<li>$quantity articles proposés par $business à $price €</li>";
        
        while($row = $result -> fetch_assoc()) {
            $quantity = $row["quantity"];
            $business = $row["BusinessName"];
            $price = $row["price"];
            echo "<li>$quantity articles proposés par $business à $price €</li>";
        }

        echo "</ul>";

    ?>

    <!-- an form to order an item -->
    <br>
    <form action="../customer/add_to_cart.php" method="POST">
        <label for="">Nombre d'articles : </label>
        <input type="number" value="1" min="1" max=<?=$max_quantity?> name="item-number">
        <input type="hidden" name="productID" value=<?=$id?>>
        <select name="" id="">
            <?php

                //Display the vendors in a dropdown list to let the user to choose
                $stmt = $db -> prepare("SELECT name FROM Business,BusinessSell WHERE BusinessSell.business = Business.id AND BusinessSell.typeItem = ?");
                $stmt -> bind_param("i",$id);
                $stmt -> execute();
                $result = $stmt -> get_result();

                while ($row = $result -> fetch_assoc()) {
                    $business = $row["name"];
                    echo "<option>$business</option>";
                }
            ?>
        </select>
        <?php
            $stmt = $db -> prepare("SELECT id AS businessID FROM Business WHERE name = ?");
            $stmt -> bind_param("s",$business);
            $stmt -> execute();
            $result = $stmt -> get_result();
            $row = $result -> fetch_assoc();
        ?>
        <input type="hidden" name="businessID" value=<?=$row['businessID']?>>
        <br>
        <button type="submit">Ajouter au panier</button>
    </div>
</form>