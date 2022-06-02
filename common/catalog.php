<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/catalog.css">
    <link href="../style/basic.css" rel="stylesheet">
    <title>Catalogue</title>
</head>
<body>
    <?php include_once("../include_files/menu.php");?>
    <form action="./item_display.php" method="GET">
    <h1>Catalogue</h1>
    <div class="container">
        <?php
            include_once("../include_files/db_connection.php");

            $stmt = $db->prepare("SELECT * FROM TypeItem ORDER BY id");
            $stmt -> execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()) {
                $item = $row["name"];
                echo "<div class='article'>";
                echo "<div class='item'><h3>$item</h3></div>";
                echo "<div class='item'><img src='../uploaded_files/" . $row["id"] . ".jpg' width='300'></div>";
                echo "<div class='item'><button value='" . $row["id"] . "' name='item' type='submit' class='button'>Voir</button></div>";
                echo "</div>";
            }
        ?>
    </div>
    </form>
</body>
</html>
