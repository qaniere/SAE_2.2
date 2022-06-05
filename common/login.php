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
    <?php include_once("../include_files/menu.php");?>
    <form action="login.php" method="post">
        <h1>Connexion</h1>
        <label for="login">Votre nom d'utilisateur, le nom de l'entreprise ou votre adresse e-mail</label> <br>
        <input type="text" name="login" id="login" placeholder="login">
        <br> <br>
        <input type="password" name="password" id="password" placeholder="Mot de passe">
        <br> <br>
        <fieldset>
            <legend>Sélectionnez le type de compte : </legend>
            <div>
                <input type="radio" id="radio-customer" name="radio_account_type" value="customer" checked>
                <label for="radio-customer">Compte particulier</label>
            </div>
            <div>
                <input type="radio" id="radio-business" name="radio_account_type" value="business">
                <label for="radio-business">Compte entreprise</label>
            </div>
        </fieldset>
        <button type="submit">Connexion</button>
    </form>
    <?php
        if(isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["radio_account_type"])) {
        //If form is completed

            include_once("../include_files/db_connection.php");
            extract($_POST); //Transform $_POST into variables

            if($radio_account_type == "customer") {
            //The user is a customer 
            
                $stmt = $db->prepare("SELECT * FROM Customer LEFT JOIN CustomerProtectedData ON Customer.id = CustomerProtectedData.id WHERE Customer.login = ? OR CustomerProtectedData.email = ?");
                $stmt ->bind_param("ss", $login, $login);
                $stmt ->execute();

                $result = $stmt ->get_result() ->fetch_assoc(); //Get the SQL data as an array 
                
                if($result == NULL) {
                    echo "Impossible de trouver à compte particulier associé à '$login'";

                } else {
                    
                    if(password_verify($password, $result["password_hash"])) {
                        foreach ($result as $key => $value) {
                            $_SESSION[$key] = $value;
                        }

                        $_SESSION["account_type"] = "customer";
                        header("Location: ../customer/account.php");

                    } else {
                        echo "Mot de passe incorrect !";
                    }
                }

            } else if($radio_account_type == "business") {
            //The user is a business

                $stmt = $db->prepare("SELECT * FROM Business WHERE Business.name = ? OR Business.email = ?");
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

                        $_SESSION["account_type"] = "business";
                        header("Location: ../business/dashboard.php");

                    } else {
                        echo "Mot de passe incorrect !";
                    }
                }
            }
        }
    ?>
</body>
</html>
