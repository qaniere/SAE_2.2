<?php
    session_start();
    
    if (isset($_SESSION["cart"]) && isset($_SESSION["cart"][$_POST["productID"]]) && isset($_POST["quantity"])) {
        if ($_POST["quantity"] > 0) {
            $_SESSION["cart"][$_POST["productID"]] = $_POST["quantity"];
        } else {
            unset($_SESSION["cart"][$_POST["productID"]]);
        }
    }

    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
?>