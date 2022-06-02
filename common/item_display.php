<?php
    include_once("../include_files/menu.php");
    if (isset($_GET["item"])) {
        $id = $_GET["item"];

    } else {
        die("Aucun article séléctionné.");
    }

    include_once("../db_connection.php");

    //Check if the item exists
    $exists = $db->query("SELECT typeItem FROM BusinessSell WHERE typeItem = $id");
    $row = $exists->fetch_assoc();
    if (!isset($row["typeItem"])) {
        die("Cet article n'est pas en vente actuellement.<br><a href='../catalog.php'>Retourner au catalogue</a>");
    }

   //Get the item's name, his price, the quantity available and the vendors
    $stmt = $db -> prepare("SELECT TypeItem.name AS ItemName, price, quantity, Business.name AS BusinessName FROM TypeItem,BusinessSell,Business WHERE TypeItem.id = ? AND TypeItem.id = typeItem AND Business.id = BusinessSell.business");
    $stmt -> bind_param("i",$id);
    $stmt -> execute();

    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
    
    $name = $row["ItemName"];
    echo "$name<br><br>";

    $max_quantity = 0;
    $quantity = $row["quantity"];
    if ($quantity > $max_quantity) $max_quantity = $quantity; 

    $business = $row["BusinessName"];
    $price = $row["price"];
    echo "$quantity articles proposés par $business à $price €<br><br>";

    while($row = $result -> fetch_assoc()) {
        $quantity = $row["quantity"];
        $business = $row["BusinessName"];
        $price = $row["price"];
        echo "$quantity articles proposés par $business à $price €<br><br>";
    }

    //Item picture
    echo "<img src='../uploaded_files/" . $id . ".jpg' height='400'><br>";
    
    //Display each attributes of the item.
    $stmt = $db -> prepare("SELECT attribute,value FROM TypeItemDetails WHERE typeItem = ?");
    $stmt -> bind_param("i",$id);
    $stmt -> execute();

    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();

    $attribute = $row["attribute"];
    $value = $row["value"];
    echo "$attribute : $value<br>";

    while ($row = $result -> fetch_assoc()) {
        $attribute = $row["attribute"];
        $value = $row["value"];
        echo "$attribute : $value<br>";
    }
?>

<!-- an form to order an item -->
<br>
<link href="../style/basic.css" rel="stylesheet">
<form action="a preciser" method="POST">
    <label for="">Nombre d'articles : </label>
    <input type="number" value="1" min="1" max=<?php echo $max_quantity?> name="nbArticles">
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
    <br>
    <button type="submit">Commander</button>
</form>