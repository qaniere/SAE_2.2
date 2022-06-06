<?php
    session_start();
    $message = "";

    if(isset($_POST["business_name"]) && isset($_POST["mail"]) && isset($_POST["country"]) && isset($_POST["password"]) && isset($_POST["passwordConf"])) {
        //If form is complete

            include_once("../include_files/db_connection.php"); //Connect to db only when it's needed
            extract($_POST); //Transform $_POST["var"] to $var
        
            $stmt = $db ->prepare("SELECT * FROM Business WHERE Business.name = ?");
            $stmt ->bind_param("s", $business_name);
            $stmt ->execute();

            $result = $stmt ->get_result();
            $count_login = $result ->num_rows;
            //If this var is different of 0, then insertion can't be done

            $stmt = $db ->prepare("SELECT * FROM Business  WHERE Business.email = ?");
            $stmt ->bind_param("s", $mail);
            $stmt ->execute();

            $result = $stmt ->get_result();
            $count_email= $result ->num_rows;
                
            if ($password != $passwordConf) {
                $message = "<strong>Les mots de passe ne correspondent pas.</strong>";
            }
            else if($count_login != 0) {
                $message = "<strong>Ce nom d'entreprise est déjà utilisé.</strong>";

            } else if($count_email != 0) {
                $message = "<strong>Cette adresse e-mail est déjà utilisée.</strong>";

            } else {

                $password_hashed = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $db ->prepare("INSERT INTO Business (email, name, country, password_hash) VALUES (?, ?, ?, ?)");
                $stmt ->bind_param("ssss", $mail, $business_name, $country, $password_hashed);
                $stmt ->execute();
                
                $_SESSION["id"] = $db ->insert_id;
                $_SESSION["account_type"] = "business";
                $_SESSION["name"] = $business_name;
                $_SESSION["mail"] = $mail;
                $_SESSION["country"] = $country;

                header("Location: " ."dashboard.php");
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription entreprise</title>
    <link href="../style/basic.css" rel="stylesheet">
    <link href="../style/form.css" rel="stylesheet">
</head>
<body>
    <?php include_once("../include_files/menu.php");?>
    <div id="form-container">
        <form action="register.php" method="post">
            <h1 id="form-title">Inscription entreprise</h1>
            <div class="form-question">
                <label for="business-name"><strong>Nom de l'entreprise</strong></label>
                <br>
                <input type="text" name="business_name" id="business-name" placeholder="Exemple : JohnDoe Inc." required>
            </div>
            <div class="form-question">
                <label for="email"><strong>Adresse e-mail</strong></label>
                <br>
                <input type="email" name="mail" id="mail" placeholder="Exemple : john.doe@compagny.inc" required>
            </div>
            <div class="form-question">
                <label for="country"><strong>Pays de l'entreprise</strong></label>
                <br>
                <input type="text" name="country" id="country" placeholder="Exemple : France" required>
            </div>
            <div class="form-question">
                <label for="password"><strong>Mot de passe</strong></label>
                <br>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-question">
                <label for="passwordConf"><strong>Confirmation du mot de passe</strong></label>
                <br>
                <input type="password" name="passwordConf" id="passwordConf" required>
            </div>
            <div class="form-question">
                <button type="submit">Inscription</button>
            </div>
            <?php
                echo $message;
            ?>
            <p> Cette page d'inscription est réservée aux entreprise. Vous êtes un particulier ? <a href="../customer/register.php">Cliquez ici</a> </p>
        </form>
    </div>
</body>
</html>
