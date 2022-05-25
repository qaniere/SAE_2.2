<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <form action="signup.php" method="post">
        <input type="text" name="login" id="login" placeholder="Login" required>
        <br> <br>
        <input type="email" name="mail" id="mail" placeholder="e-mail" required>
        <br> <br>
        <input type="text" name="surname" id="surname" placeholder="Nom" required>
        <br> <br>
        <input type="text" name="firstname" id="firstname" placeholder="Prénom" required>
        <br> <br>
        <input type="password" name="password" id="password" placeholder="mot de passe" required>
        <br> <br>
        <button type="submit">Connection</button>
    </form>
    <?php
        session_start(); //Allow to use $_SESSION var

        if(isset($_POST["login"]) && isset($_POST["mail"]) && isset($_POST["password"]) && isset($_POST["surname"]) && isset($_POST["firstname"])) {
        //If form is complete

            include_once("../db_connection.php"); //Connect to db only when it's needed
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
                   
            if($count_login != 0) {
                echo "Ce login est déjà utilisé.";

            } else if($count_email != 0) {
                echo "Cette adresse e-mail est déjà utilisé.";

            } else {

                $password_hashed = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $db ->prepare("INSERT INTO Customer (login, password_hash, stash) VALUES (?, ?, 0)");
                $stmt ->bind_param("ss", $login, $password_hashed);
                $stmt ->execute();

                $id = $db->insert_id; //The id is automatically incrementing in the database when a tuple is inserted

                $stmt = $db ->prepare("INSERT INTO CustomerProtectedData (id, surname, firstname, email) VALUES (?, ?, ?, ?)");
                $stmt ->bind_param("isss", $id, $surname, $firstname, $mail);
                $stmt ->execute();

                echo "Inscription réussie. Allez vous connectez sur <a href='login.php'>login.php</a>.";
            }
        }
    ?>
</body>
</html>
