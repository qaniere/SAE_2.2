<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription entreprise</title>
    <link href="../style/basic.css" rel="stylesheet">
</head>
<body>
    <?php include_once("../include_files/menu.php");?>
    <form action="register.php" method="post">
        <h1>Inscription entreprise</h1>
        <input type="text" name="business_name" id="business-name" placeholder="Nom de l'entreprise" required>
        <br> <br>
        <input type="email" name="mail" id="mail" placeholder="e-mail" required>
        <br> <br>
        <input type="text" name="country" id="country" placeholder="Pays" required>
        <br> <br>
        <input type="password" name="password" id="password" placeholder="mot de passe" required>
        <br> <br>
        <button type="submit">Inscription</button>
        <p> Cette page d'inscription est réservée aux entreprise. Vous êtes un particulier ? <a href="../customer/register.php">Cliquez ici</a> </p>
    </form>
    <?php
        if(isset($_POST["business_name"]) && isset($_POST["mail"]) && isset($_POST["country"]) && isset($_POST["password"])) {
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
                   
            if($count_login != 0) {
                echo "Ce nom d'entreprise est déjà utilisé.";

            } else if($count_email != 0) {
                echo "Cette adresse e-mail est déjà utilisée.";

            } else {

                $password_hashed = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $db ->prepare("INSERT INTO Business (email, name, country, password_hash) VALUES (?, ?, ?, ?)");
                $stmt ->bind_param("ssss", $mail, $business_name, $country, $password_hashed);
                $stmt ->execute();
                
                $_SESSION["id"] = $db ->insert_id;
                $_SESSION["account_type"] = "business";
                $_SESSION["business_name"] = $business_name;
                $_SESSION["mail"] = $mail;
                $_SESSION["country"] = $country;

                header("Location: " ."dashboard.php");
            }
        }
    ?>
</body>
</html>
