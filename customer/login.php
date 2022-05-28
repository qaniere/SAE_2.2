<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="../style/basic.css" rel="stylesheet">
</head>
<body>
    <form action="login.php" method="post">
        <h1>Connexion</h1>
        <input type="text" name="login" id="login" placeholder="Votre login ou votre adresse email">
        <br> <br>
        <input type="password" name="password" id="password" placeholder="Mot de passe">
        <br> <br>
        <button type="submit">Connexion</button>
    </form>
    <?php
        if(isset($_POST["login"]) && isset($_POST["password"])) {
        //If form is completed

            extract($_POST);    
            include_once("../db_connection.php");

            $stmt = $db->prepare("SELECT * FROM Customer LEFT JOIN CustomerProtectedData ON Customer.id = CustomerProtectedData.id WHERE Customer.login = ? OR CustomerProtectedData.email = ?");
            $stmt ->bind_param("ss", $login, $login);
            $stmt ->execute();

            $result = $stmt ->get_result() ->fetch_assoc(); //Get the SQL data as an array 
            
            if($result == NULL) {
                echo "Impossible de trouver à compte associé à '$login'";

            } else {
                
                if(password_verify($password, $result["password_hash"])) {
                    foreach ($result as $key => $value) {
                        $_SESSION[$key] = $value;
                    }

                    echo "Connexion réussie. Vous pouvez vous rendre sur <a href='account.php'>account.php</a>";

                } else {
                    echo "Mot de passe incorrect !";
                }
            }
            
        }
    ?>
</body>
</html>
