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
    <title>Catalogue recherches d'entreprises</title>
</head>
<body>
    <?php include_once("../include_files/menu.php");?>
    <h1>Les recherches des entreprises</h1>
    <p>Nos partenaires redonnent une vie à vos vieux appareils.</p>
    <div class="container">
        <?php
            include_once("../include_files/db_connection.php");

            $stmt = $db->prepare("SELECT *, TypeItem.name, BusinessBuy.price FROM BusinessBuy JOIN TypeItem ON BusinessBuy.typeItem = TypeItem.id WHERE (typeItem, price) IN (SELECT typeItem, MIN(price) FROM BusinessBuy WHERE BusinessBuy.quantity > 0 GROUP BY typeItem);");
            $stmt -> execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()) {
                $item = $row["name"];
                $price = $row["price"];

                echo "<a href='../common/item_display.php?item=". $row['id']. "'>";
                echo "<div class='article'>";
                echo "<div class='article-text'><img class='article-picture' src='../catalog_pictures/" . $row["id"] . "." .  $row["file_extension"] . "' width='300'></div>";
                echo "<div class='article-tex'><h3>$item</h3><h3>$price €</div>";
                echo "</div>";
                echo "</a>";
            }

            if($result->num_rows == 0) {
                echo "Oups, aucun article n'est disponible pour le moment :(";
            }
        ?>
    </div>
</body>
</html>
