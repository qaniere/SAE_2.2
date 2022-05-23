<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include "../login_db.php";
        session_start();
    ?>
    <form action="login.php" method="post">
        <input type="text" name="login" id="log" placeholder="login ou e-mail">
        <input type="password" name="passwd" id="pwd" placeholder="mot de passe">
        <button type="submit"> Connection </button>
    </form>

    <?php
        $login = $_POST['login'];
        $pwd = $_POST['passwd'];

        $stmt = $db -> prepare("SELECT * FROM CustomerLogin WHERE login='$login'");
        $stmt -> execute();
        $logExist = $stmt -> store_result();
        
        $stmt = $db -> prepare("SELECT * FROM CustomerLogin WHERE email='$login'");
        $stmt -> execute();
        $mailExist = $stmt -> store_result();

        $stmt = $db -> prepare("SELECT pwd_hash FROM CustomerLogin WHERE login='$login' OR email='$login'");
        $stmt -> execute();
        $pwdres = $stmt -> get_result();
        $pwd_hash = $pwdres -> fetch_assoc();

        if ($logExist || $mailExist) {
            if (password_verify($pwd ,$pwd_hash['pwd_hash'])) {
                $_SERVER['user'] = $login;
                echo "connection réussie";
            }
        }



    ?>
</body>
</html>
