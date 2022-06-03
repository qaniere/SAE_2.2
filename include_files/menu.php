<nav>
    <a href="../index.php"> 
        <img src="../img/logo.png" alt="logo" id="menu-logo">
    </a>
    <img id="mobile-menu-icon" src="../img/menu.png" alt="L'icone du menu sur mobile">
    <div id="menu" role="menu">    
        <div class="menu-item">
            <a href="../index.php">Accueil</a>
        </div>
        <div class="menu-item" role="menuitem">
            <a href="../common/catalog.php">Catalogue</a>
        </div>
        <div class="menu-item" role="menuitem">
            <a href="">Politique RSE</a>
        </div>
        <div class="menu-item" role="menuitem">
            <a href="">Carte fidélité</a>
        </div>
        <div class="menu-item" role="menuitem">
            <a href="">Notre équipe</a>
        </div>
        <div class="menu-item" role="menuitem">
            <a href="">Contact</a>
        </div>
        <div id="account-pill">
            <img id="user-logo" src="../img/user.png">
            <?php
                if(isset($_SESSION["id"])) {
                    $name = $_SESSION["firstname"];
                    echo "<a href='../customer/account.php'>Bonjour $name !</a>";

                } else {
                    echo "<a href='../customer/login.php'>Vous n'êtes pas connecté</a>";
                }
            ?>
        </div>
</nav>
<script src="../scripts/menu.js"></script>
<link rel="stylesheet" href="../style/menu.css">