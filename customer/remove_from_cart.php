<?php
    session_start();
    if (isset($_SESSION["cart"]) && isset($_SESSION["cart"][$_POST["productID"]])) {
        unset($_SESSION["cart"][$_POST["productID"]][$_POST['businessID']]);
    }
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
?>
