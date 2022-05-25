<?php 

    $file = fopen(stream_resolve_include_path(".env"), "r"); 
    //stream_resolve_include_path find the good path for .env file

    if($file == false) { 
    //If a error occurs during the opening of the file

        echo ("Can't load .env file !");
        die();
    }

    while(($line = fgets($file)) !== false) {
    //Iterate over every line of the file

        $values = explode("=", $line); //Transform a string "x=y" to an array like [x, y]
        ${$values[0]} = substr_replace($values[1] , "", -1); //Transform the array [x, y] to $x = y
        //The substr remove the space at the end of the line
        
    }

    fclose($file);

    try {
        $db = mysqli_connect($DB_URL, $DB_LOGIN, $DB_PASSWORD, $DB_NAME);
    
    } catch (Exception $e) {
        echo "Échec : $e";
        die();
    }

    $db ->set_charset("utf8mb4");
?>
