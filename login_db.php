<?php 
    try {
        $db = mysqli_connect("192.168.128.4","php","php","coff_it");
    
    } catch (Exception $e) {
        echo "Echec";
        die();
    }
?>
