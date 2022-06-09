<?php
    session_start();
    $message = "";

    if(isset($_POST["login"]) && isset($_POST["mail"]) && isset($_POST["password"]) && isset($_POST["passwordConf"]) && isset($_POST["surname"]) && isset($_POST["firstname"])) {
        //If form is complete
        
            include_once("../include_files/db_connection.php"); //Connect to db only when it's needed
            extract($_POST); //Transform $_POST["var"] to $var
        
            $stmt = $db ->prepare("SELECT * FROM Customer WHERE Customer.login = ?");
            $stmt ->bind_param("s", $login);
            $stmt ->execute();

            $result = $stmt ->get_result();
            $count_login = $result ->num_rows;
            //If this var is different of 0, then insertion can't be done

            $stmt = $db ->prepare("SELECT * FROM Customer LEFT JOIN CustomerProtectedData ON Customer.id = CustomerProtectedData.id WHERE CustomerProtectedData.email = ?");
            $stmt ->bind_param("s", $mail);
            $stmt ->execute();

            $result = $stmt ->get_result();
            $count_email= $result ->num_rows;
                
            if ($password != $passwordConf) {
                $message = "<strong>Les mots de passe ne correspondent pas.</strong>";
                
            } else if($count_login != 0) {
                $message = "<strong>Ce login est déjà utilisé.</strong>";

            } else if($count_email != 0) {
                $message = "<strong>Cette adresse e-mail est déjà utilisé.</strong>";

            } else if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $message = "<strong>Adresse email non valide.</strong>";

            } else {

                $password_hashed = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $db ->prepare("INSERT INTO Customer (login, password_hash, stash) VALUES (?, ?, 0)");
                $stmt ->bind_param("ss", $login, $password_hashed);
                $stmt ->execute();

                $id = $db->insert_id; //The id is automatically incrementing in the database when a tuple is inserted

                $stmt = $db ->prepare("INSERT INTO CustomerProtectedData (id, surname, firstname, email) VALUES (?, ?, ?, ?)");
                $stmt ->bind_param("isss", $id, $surname, $firstname, $mail);
                $stmt ->execute();

                $_SESSION["id"] = $id;
                $_SESSION["login"] = $login;
                $_SESSION["surname"] = $surname;
                $_SESSION["firstname"] = $firstname;
                $_SESSION["mail"] = $mail;
                $_SESSION["stash"] = 0;
                $_SESSION["account_type"] = "customer";

                header("Location: account.php");
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription particuliers</title>
    <link href="../style/basic.css" rel="stylesheet">
    <link href="../style/form.css" rel="stylesheet">
</head>
<body>
    <?php include_once("../include_files/menu.php");?>
    <div id="form-container">
        <form action="register.php" method="post">
            <h1 id="form-title">Inscription particuliers</h1>
            <div class="form-question">
                <label for="login"><strong>Votre identifiant</strong></label>
                <br>
                <input type="text" name="login" id="login" placeholder="Exemple : johndoe89" required>
            </div>
            <div class="form-question">
                <label for="email"><strong>Votre adresse e-mail</strong></label>
                <br>
                <input type="email" name="mail" id="mail" placeholder="Exemple : john.doe@mail.com" required>
            </div>
            <div class="form-question">
                <label for="surname"><strong>Votre nom de famille</strong></label>
                <br>
                <input type="text" name="surname" id="surname" placeholder="Exemple : DOE" required>
            </div>
            <div class="form-question">
                <label for="firstname"><strong>Votre prénom</strong></label>
                <br>
                <input type="text" name="firstname" id="firstname" placeholder="Exemple : John" required>
            </div>           
            <div class="form-question">
                <label for="password"><strong>Votre mot de passe</strong></label>
                <br>
                <input type="password" name="password" id="password" required>
            </div> 
            <div class="form-question">
                <label for="passwordConf"><strong>Confirmation du mot de passe</strong></label>
                <br>
                <input type="password" name="passwordConf" id="passwordConf" required>
            </div>
            <div class="form-question">
                <input type="submit" value="Inscription">
            </div>
            <?php
                echo $message;
            ?>
            <p>
                Cette page d'inscription est réservée aux partucliers. Vous êtes une entreprise ? <a href="../business/register.php">Cliquez ici</a>
            </p>
            <br>
            <p>
                Vous avez déjà un compte ? <a href="../common/login.php">Cliquez ici</a>
            </p>
        </form>
    </div>
</body>
</html>
