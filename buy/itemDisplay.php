<?php

    $id = $_GET["item"];
    
    include "../login_db.php";
    //Récupère le nom de l'objet, ses attributs et leurs valeurs
    $stmt = $db -> prepare("SELECT Business.name AS BusinessName,TypeItem.name AS ItemName,price,quantity,business,attribute,value FROM BusinessSell,Business,TypeItem,TypeItemDetails WHERE TypeItem.id = ? AND TypeItemDetails.typeItem = TypeItem.id AND Business.id = BusinessSell.Business");
    $stmt -> bind_param("i",$id);
    $stmt -> execute();

    $rep = $stmt -> get_result();
    $row = $rep -> fetch_assoc();

    // Nom, prix et quantité disponible de l'item
    $name = $row["ItemName"];
    echo "$name<br><br>";

    $price = $row["price"];
    $quantity = $row["quantity"];
    $business = $row["BusinessName"];

    echo "Prix : $price €<br> $quantity articles proposés par $business<br><br>";

    //affiche chaque attribut avec sa valeur
    $attribute = $row["attribute"];
    $value = $row["value"];
    echo "$attribute : $value<br>";

    while ($row = $rep -> fetch_assoc()) {
        $attribute = $row["attribute"];
        $value = $row["value"];
        echo "$attribute : $value<br>";
    }
?>

<!-- Un formulaire pour commander l'item -->
<br>
<form action="a preciser" method="POST">
    <label for="">Nombre d'articles : </label>
    <input type="number" min="1" max=<?php echo $quantity?> name="nbArticles">
    <br>
    <button type="submit">Commander</button>
</form>