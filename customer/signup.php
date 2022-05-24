<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <?php
        include "../login_db.php";
    ?>
    <form action="signup.php" method="post">
        <input type="text" name="login" id="log" placeholder="login">
        <input type="text" name="mail" id="mail" placeholder="e-mail">
        <input type="password" name="passwd" id="pwd" placeholder="mot de passe">
        <button type="submit"> Connection </button>
    </form>

    <?php
        $login = $_POST['login'];
        $mail = $_POST['mail'];
        $pwd = $_POST['passwd'];

        $stmt = $db -> prepare("SELECT * FROM CustomerLogin WHERE login='$login'");
        $stmt -> execute();
        $logExist = $stmt -> store_result();
        
        $stmt = $db -> prepare("SELECT * FROM CustomerLogin WHERE email='$mail'");
        $stmt -> execute();
        $mailExist = $stmt -> store_result();

        $stmt = $db -> prepare("SELECT MAX(id) AS id FROM CustomerLogin");
        $stmt -> execute();
        $idres = $stmt -> get_result();
        $idrow = $idres -> fetch_assoc();
        $id = $idrow['id']+1;
        
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $stmt = $db -> prepare("INSERT INTO CustomerLogin VALUES ($id, '$login', '$mail', '$hash')");

        if ($logExist) {
            echo "Le login est déjà utilisé.";
        } else if ($mailExist) {
            echo "L'e-mail est déjà utilisé.";
        } else {
            $stmt -> execute();
        }
    ?>
</body>
</html>
