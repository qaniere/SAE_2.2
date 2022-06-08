<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre compte</title>
    <link href="../style/basic.css" rel="stylesheet">
    <link href="../style/account.css" rel="stylesheet">
</head>
<body>
    <?php include_once("../include_files/menu.php");?>
    <div id="account-container">
        <h1>Votre compte</h1>
         <?php        
            if(isset($_SESSION["id"])) {

                include_once("../include_files/db_connection.php");
                
                //Select informations of customer
                $stmt = $db ->prepare("SELECT * FROM Customer JOIN CustomerProtectedData ON Customer.id = CustomerProtectedData.id  WHERE Customer.id = ?");
                $stmt ->bind_param("i", $_SESSION["id"]);
                $stmt ->execute();

                $result = $stmt ->get_result();
                $row = $result ->fetch_assoc();

                $login = $_SESSION["login"];
                $stash = $row["stash"];
                $email = $row["email"];

                echo "<h2>Vos informations</h2>";
                echo "<ul>";
                echo "<li><strong>Login :</strong> $login</li>";
                echo "<li><strong>Cagnotte fidelité :</strong> $stash</li>";
                echo "<li><strong>Adresse email :</strong> $email</li>";
                echo "</ul>";

                //Get all elements extracted by the customer
                $stmt = $db ->prepare("SELECT name, quantity FROM Mendeleiev, CustomerExtraction WHERE Customer = ? AND Z = element");
                $stmt ->bind_param("i", $_SESSION["id"]);
                $stmt ->execute();

                $result = $stmt -> get_result();
                while ($row = $result -> fetch_assoc()) {
                    $element = $row["name"];
                    $quantity = $row["quantity"];
                    echo "$element : $quantity<br>";
                }

                //Get number of order of the customer
                $stmt = $db -> prepare("SELECT COUNT(id) FROM CustomerOrder WHERE CustomerID = ?");
                $stmt -> bind_param("i", $_SESSION["id"]);
                $stmt -> execute();
                $result = $stmt -> get_result();
                $row = $result -> fetch_assoc();
                $max = $row["COUNT(id)"]/10 % 10;

                //Setting the offset for pagination
                $offset = 0;
                if (isset($_GET["history"])) {

                    if ($_GET["history"] == "previous") {
                        if ($offset != 0) {
                            $offset -= 10;
                        }  
                    
                    } else if ($_GET["history"] == "next") {
                        if ($offset < $max) {
                            $offset += 10;
                        }
                    }
                }
                
                //Getting the order history
                echo "<h3>Historique des achats</h3>";
                echo "<table>";
                echo "<tr>";
                echo "<th>Numéro de commande</th>";
                echo "<th>Nom de l'objet</th>";
                echo "<th>Vendeur</th>";
                echo "<th>Photo</th>";
                echo "<th>Lien vers l'article</th>";
                echo "</tr>";

                $stmt = $db->prepare("SELECT CustomerOrder.id AS OrderID, TypeItem.id AS id, TypeItem.name AS itemName, TypeItem.file_extension AS file_extension, Business.name AS businessName, CustomerOrder.quantity, price FROM CustomerOrder JOIN BusinessSell ON CustomerOrder.businessID = BusinessSell.business AND CustomerOrder.itemID = BusinessSell.typeItem JOIN Business ON CustomerOrder.businessID = Business.id JOIN TypeItem ON CustomerOrder.itemID = TypeItem.id WHERE CustomerID = ? LIMIT 10 OFFSET ?");
                $stmt->bind_param("ii", $_SESSION["id"], $offset);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $order_id = $row["OrderID"];
                    $item_name = $row["itemName"];
                    $business_name = $row["businessName"];
                    $quantity = $row["quantity"];
                    $price = $row["price"]*$quantity;
                    $id = $row["id"];
                    $file_extension = $row["file_extension"];

                    echo "<tr>";
                    echo "<td>$order_id</td>";
                    echo "<td>$item_name</td>";
                    echo "<td>$business_name</td>";
                    echo "<td><img class='history-image'src='../catalog_pictures/$id.$file_extension'></td>";
                    echo "<td><a href='../common/item_display.php?item=$id'>Voir l'article</a></td>";
                    echo "</tr>";
                }

                echo "</table>";
          
                echo "<form action='../customer/account.php' method='get'>
                    <button type='submit' name='history' value='previous'>< Page précédente</button>
                    <button type='submit' name='history' value='next'>Page suivante ></button>
                </form>";

            } else {
                echo "Vous n'êtes pas connecté. Allez sur <a href='login.php'>login.php</a>.";
            }
        ?>
    </div>
</body>
</html>