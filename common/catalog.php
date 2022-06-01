<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./catalog.css">
    <title>Catalogue de nos articles</title>
</head>
<body>
    
    
    
    <form action="./item_display.php" method="GET">
    <h1>Catalogue de nos articles</h1>
    <div class="container">
        <?php
            include "../db_connection.php";

            $stmt = $db->prepare("SELECT MAX(id) AS MaxId FROM TypeItem");
            $stmt -> execute();
            $rep = $stmt ->get_result();
            $row = $rep -> fetch_assoc();

            $maxId = $row["MaxId"];

            //affiche chaque article disponible classés par id
            for ($i = 1; $i <= $maxId; $i++) {
                $stmt = $db->prepare("SELECT name FROM TypeItem WHERE id = ?");
                $stmt -> bind_param("i",$i);
                $stmt -> execute();

                $rep = $stmt->get_result();
                $row = $rep->fetch_assoc();

                $item = $row["name"];
                echo '<div class="article">';
                echo "<div class='item'><h3>$item</h3></div>";
                echo '<div class="item"><img src="../uploaded_files/' . $i . '.jpg" width="300"></div>';
                echo '<div class="item"><button value="' . $i . '" name="item" type="submit" class="button">Voir</button></div>';
                echo '</div>';
            }
        ?>
    </div>
    </form>
</body>
</html>
