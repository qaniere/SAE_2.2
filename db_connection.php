<?php 

    $file = fopen(stream_resolve_include_path(".env"), "r");

    if($file == false) {
        echo ("Can't load .env file !");
        die();
    }

    while(($line = fgets($file)) !== false) {
        $values = explode("=", $line);
        ${$values[0]} = substr_replace($values[1] ,"",-1);
        
    }

    fclose($file);

    try {
        $db = mysqli_connect($DB_URL, $DB_LOGIN, $DB_PASSWORD, $DB_NAME);
    
    } catch (Exception $e) {
        echo "Echec";
        die();
    }
?>
