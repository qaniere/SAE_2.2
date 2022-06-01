<?php

    if (isset($_GET["item"])) {
        $id = $_GET["item"];
    } else {
        die("Aucun article séléctionné.");
    }

    include "../db_connection.php";

    //vérifie si l'article demandé existe
    $exists = $db->query("SELECT typeItem FROM BusinessSell WHERE typeItem = $id");
    $row = $exists->fetch_assoc();
    if (!isset($row["typeItem"])) {
        die("Cet article n'est pas en vente actuellement.<br><a href='../catalog.php'>Retourner au catalogue</a>");
    }

    //Récupère le nom de l'objet, les entreprises qui le vendent, et à quel prix et les affiche
    $stmt = $db -> prepare("SELECT TypeItem.name AS ItemName, price, quantity, Business.name AS BusinessName FROM TypeItem,BusinessSell,Business WHERE TypeItem.id = ? AND TypeItem.id = typeItem AND Business.id = BusinessSell.business");
    $stmt -> bind_param("i",$id);
    $stmt -> execute();

    $rep = $stmt -> get_result();
    $row = $rep -> fetch_assoc();
    
    $name = $row["ItemName"];
    echo "$name<br><br>";

    $maxQuantity = 0;
    $quantity = $row["quantity"];
    if ($quantity > $maxQuantity) $maxQuantity = $quantity; 

    $business = $row["BusinessName"];
    $price = $row["price"];
    echo "$quantity articles proposés par $business à $price €<br><br>";

    while ($row = $rep -> fetch_assoc()) {

        $quantity = $row["quantity"];
        $business = $row["BusinessName"];
        $price = $row["price"];
        echo "$quantity articles proposés par $business à $price €<br><br>";
    }

    //photo de l'article
    echo "<img src='../uploaded_files/" . $id . ".jpg' height='400'><br>";
    
    //affiche chaque attribut avec sa valeur
    $stmt = $db -> prepare("SELECT attribute,value FROM TypeItemDetails WHERE typeItem = ?");
    $stmt -> bind_param("i",$id);
    $stmt -> execute();

    $rep = $stmt -> get_result();
    $row = $rep -> fetch_assoc();

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
    <input type="number" value="1" min="1" max=<?php echo $maxQuantity?> name="nbArticles">
    <select name="" id="">
        <?php

            //affiche le nom des entreprises vendant le produit dans un menu déroulant, pour choisir chez quelle entreprise acheter le produit
            $stmt = $db -> prepare("SELECT name FROM Business,BusinessSell WHERE BusinessSell.business = Business.id AND BusinessSell.typeItem = ?");
            $stmt -> bind_param("i",$id);
            $stmt -> execute();
            $rep = $stmt -> get_result();

            while ($row = $rep -> fetch_assoc()) {
                $business = $row["name"];
                echo "<option>$business</option>";
            }
        ?>
    </select>
    <br>
    <button type="submit">Commander</button>
</form>