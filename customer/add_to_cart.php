<?php
    session_start();
    include_once("../include_files/db_connection.php");
    
    if(isset($_POST["productID"],$_POST["item-number"])) {

        $id = $_POST["productID"];
        $quantity = $_POST["item-number"];
        $businessID = $_POST["businessID"];

        $stmt = $db -> prepare("SELECT TypeItem.*, price FROM BusinessSell LEFT JOIN TypeItem ON TypeItem.id = BusinessSell.typeItem WHERE TypeItem.id = ? AND BusinessSell.business = ?");
        $stmt -> bind_param("ii",$id,$businessID);
        $stmt -> execute();
        $result = $stmt -> get_result();
        $row = $result -> fetch_assoc();

        if($row) {
            $price = $row["price"];
            $total = $price * $quantity;
            
            //Verify if $_SESSION["cart"] exist and if is an array
            if (isset($_SESSION["cart"]) && is_array($_SESSION["cart"])) {

                //Verify if the ItemID exist in the array

                if (array_key_exists($id, $_SESSION["cart"])) {
                    //Foreach loop that verify if the item is sold from the same business

                    foreach ($_SESSION['cart'][$id] as $key => $value) {
                        
                        //If it is add the quantity to the already existing one in $_SESSION["cart"][$id][$businessID]
                        if ($key == $businessID) {
                            $_SESSION['cart'][$id][$key] += $quantity;
                            break;
                        }
                    }

                //Else add the quantity to $_SESSION["cart"][$id][$businessID]
                } else {
                    $_SESSION["cart"][$id][$businessID] = $quantity;
                }

            //Else we create $_SESSION["cart"] containing an array with ItemID for index that contain an array with BusinessID for index that contain the quantity of item chosen
            } else {
                $_SESSION["cart"] = array($id => array($businessID => $quantity));
            }
            if (isset($_SERVER["HTTP_REFERER"])) {
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }

        } else {
            echo "Erreur l'objet que vous avez choisi n'est pas disponible actuellment";
        }
        
    }
?>
