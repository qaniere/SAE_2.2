<?php
session_start();
$message = "";
$error = false;

if(!isset($_SESSION["id"])){
    header("Location: ../common/login.php");
    die();
}

if($_SESSION["account_type"] == "business") {
    header("Location: ../business/dashboard.php");
    die();
}

if(isset($_POST["item-number"]) && isset($_POST["productID"]) && isset($_POST["businessID"])) {

    include_once("../include_files/db_connection.php");

    $stmt = $db->prepare("SELECT * FROM BusinessBuy WHERE typeItem = ? AND business = ? AND quantity > 0");
    $stmt->bind_param("ii", $_POST["productID"], $_POST["businessID"]);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $quantity = $row["quantity"];
        $new_quantity = $quantity - $_POST["item-number"];

        $stmt = $db->prepare("UPDATE BusinessBuy SET quantity = quantity - ? WHERE typeItem = ? AND business = ?");
        $stmt->bind_param("iii", $_POST["item-number"], $_POST["productID"], $_POST["businessID"]);
        $stmt->execute();

        $stash_to_credit = $row["price"];

        $stmt = $db->prepare("UPDATE Customer SET stash = stash + ? WHERE id = ?");
        $stmt->bind_param("ii", $stash_to_credit, $_SESSION["id"]);
        $stmt->execute();

        $stmt = $db->prepare("SELECT * FROM ExtractionFromTypeItem WHERE typeItem = ?");
        $stmt->bind_param("i", $_POST["productID"]);
        $stmt->execute();

        $result = $stmt->get_result();

        $insertion_stmt = $db->prepare("INSERT INTO CustomerExtraction (Customer, element, quantity) VALUES (?, ?, ?)");

        while($row = $result->fetch_assoc()) {
            $insertion_stmt->bind_param("iis", $_SESSION["id"], $row["element"], $row["quantity"]);
            $insertion_stmt->execute();
        }

        $message = "Votre objet a vendu été vendu avec succès ! Votre cagnotte a été créditée de $stash_to_credit €.";

    } else {
        $error = true;
        $message = "Désolé, cet article n'est plus recherché actuellement";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vente d'un objet</title>
    <link rel="stylesheet" href="../style/basic.css">
    <link rel="stylesheet" href="../style/404.css">
</head>
<body>
    <?php include_once("../include_files/menu.php"); 
    
    echo "<div id=\"page-content\">";

    if($error) {
        echo "<div class='text-container'><h1>Oups...</h1></div>";
        echo "<div class='text-container'><p>$message</p></div>";

    } else {
        echo "<div class='text-container'><h1>Merci !</h1></div>";
        echo "<div class='text-container'><p>$message</p></div>";
    }
    ?>
    </div>
</body>
</html>