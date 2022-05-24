<?php

    //Activer la ligne en dessous quand la connexion sera implémentée
    //$id = $_SESSION["id"];
    $id = 1;
    include_once("../db_connection.php");

    //Pour récupérer le login et la cagnotte 
    $stmt = $db -> prepare("SELECT stash, login FROM Customer WHERE id = ?");
    $stmt -> bind_param("i",$id);
    $stmt -> execute();

    $rep = $stmt -> get_result();
    $row = $rep -> fetch_assoc();

    $login = $row["login"];
    $cagnotte = $row["stash"];

    echo "Nom d'utilisateur : $login<br>Cagnotte fidélité : $cagnotte<br><br>";

    //Pour récupérer les métaux obtenus grâce au client
    $stmt2 = $db -> prepare("SELECT name,quantity FROM Mendeleiev,CustomerExtraction WHERE Customer = ? AND Z = element");
    $stmt2 -> bind_param("i",$id);
    $stmt2 -> execute();

    $rep2 = $stmt2 -> get_result();
    while ($row2 = $rep2 -> fetch_assoc()) {

        $element = $row2["name"];
        $quantity = $row2["quantity"];
        echo "$element : $quantity<br>";
    }
?>