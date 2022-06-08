<?php
    session_start();
    include_once("../include_files/db_connection.php");
    
    if(isset($_POST["productID"],$_POST["item-number"])) {

        $id = $_POST["productID"];
        $nbArticles = $_POST["item-number"];
        $businessID = $_POST["businessID"];

        $stmt = $db -> prepare("SELECT price FROM TypeItem,BusinessSell WHERE TypeItem.id = ? AND TypeItem.id = typeItem AND BusinessSell.business = ?");
        $stmt -> bind_param("ii",$id,$businessID);
        $stmt -> execute();
        $result = $stmt -> get_result();
        $row = $result -> fetch_assoc();

        if($row) {
            $price = $row["price"];
            $total = $price * $nbArticles;
            echo "Vous avez choisi $nbArticles articles pour $total €";

            if (isset($_SESSION["cart"]) && is_array($_SESSION["cart"])) {
                if (array_key_exists($id, $_SESSION["cart"])) {
                    foreach ($_SESSION['cart'][$id] as $key => $value) {
                        if ($key == $businessID) {
                            $_SESSION['cart'][$id][$key] += $nbArticles;
                            break;
                        }
                    }
                    
                } else {
                    $_SESSION["cart"][$id][$businessID] = $nbArticles;
                }

            } else {
                $_SESSION["cart"] = array($id => array($businessID => $nbArticles));
            }
            if (isset($_SERVER["HTTP_REFERER"])) {
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }

        } else {
            echo "Erreur l'objet que vous avez choisi n'est pas disponible actuellment";
        }
        
    }
?>
