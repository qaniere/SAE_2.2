<?php
    session_start();
    $message = "";

    if(!isset($_SESSION["id"])) { //If not logged in
        header("Location: ../common/login.php");
        die();
    }

    if($_SESSION["account_type"] != "business") { //If not a business
        header("Location: " ."../index.php");
        die();
    }

    extract($_SESSION);

    if(isset($_POST["item_name"])) {
        include_once("../include_files/db_connection.php");

        extract($_POST);

        $item_name = $item_name . "%"; //Math SQL LIKE syntax

        $stmt = $db->prepare("SELECT * FROM TypeItem WHERE name LIKE ?");
        $stmt->bind_param("s", $item_name);
        $stmt->execute();

        $result = $stmt ->get_result();
    }

    if (isset($_POST["new_item_id"])) {

        if ($_POST["price"] < 0) {
            $message = "<strong>Le prix doit être positif.</strong>";
            
        } else {

            include_once("../include_files/db_connection.php");

            $stmt = $db->prepare("INSERT INTO BusinessBuy(business, typeItem, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $id, $_POST["new_item_id"], $_POST["quantity"], $_POST["price"]);
            $stmt->execute();

            $message = "<strong>Votre offre a été ajouté au catalogue.</strong>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un objet à rechercher</title>
    <link rel="stylesheet" href="../style/basic.css">
    <link rel="stylesheet" href="../style/form.css">
</head>
<body>
    <?php include_once("../include_files/menu.php");
    if(!isset($_GET["add_item"])) {
    ?>
        <div id="form-container">
            <form action="./search_catalog_item.php" method="post" enctype="multipart/form-data">
                <h1 id="form-title">Ajouter objet du catalogue à rechercher</h1>            
                    <p>
                        Cette page vous permet de chercher un produit qui est déjà présent dans le catalogue. 
                        Si votre objet n'est pas présent dans le catalogue, utilisez <a class="link" href="sell_new_item.php">cette page</a>
                    </p>
                    <div class="form-question">
                        <label for="item-name"><strong>Nom de l'objet</strong></label>
                        <br>
                        <input type="text" name="item_name" id="item_name" required>
                    </div>
                    <div class="form-question">
                        <input type="submit" value="Rechercher">
                    </div>
                <ul>
                    <?php
                        
                        if(isset($_POST["item_name"])) {
                            echo "<h2>Choisisez l'objet à trouver :</h2>";

                            while($row = $result->fetch_assoc()) {
                                $id = $row["id"];
                                $result_item_name = $row["name"]; 
                                echo "<a class='link' href='search_catalog_item.php?add_item=$id'><li>$result_item_name</a></li>";
                            }
                        }
                        echo $message;
                    ?>
                </ul>
            </form>
        </div>
    <?php
    } else {
        include_once("../include_files/db_connection.php");

        $stmt = $db->prepare("SELECT * FROM TypeItem WHERE id = ?");
        $stmt->bind_param("i", $_GET["add_item"]);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();
        
        $item_id = $row["id"];
        $name = $row["name"];        
    ?>
        <div id="form-container">
            <form action="search_catalog_item.php" method="post">
                <h1 id="form-title">Ajouter une annonce pour "<?php echo $name;?>"</h1>              
                <div class="form-question">
                    <label for="price"><strong>Prix</strong></label>
                    <br>
                    <input type="number" name="price" id="price" required>
                </div>
                <div class="form-question">
                    <label for="quantity"><strong>Quantité</strong></label>
                    <br>
                    <input type="number" name="quantity" id="quantity" required>
                </div>
                <div class="form-question">
                    <input type="hidden" name="new_item_id" id="new_item_id" value="<?php echo $item_id; ?>">
                    <input type="submit" value="Ajouter">
                </div>
            </form>
        </div>
    <?php
    }
    ?>
</body>
</html>
