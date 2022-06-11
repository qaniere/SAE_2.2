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
        <?php 
        //$logout is a variable set on "disconnect.php" only. So, if the user
        //is disconnecting, connected only action will not be displayed.

        if(isset($_SESSION["id"]) && $_SESSION["account_type"] == "customer" && !isset($logout)) {
            echo "<div class='menu-item' role='menuitem'>
                <a href='../customer/cart.php'>Panier</a>
            </div>";
        }
        ?>
        <?php
        if(isset($_SESSION["id"]) && $_SESSION["account_type"] == "customer" && !isset($logout)) {
            echo "<div class='menu-item' role='menuitem'>
                <a href='../customer/account.php'>Mon compte</a>
            </div>";
        }
        ?>
        <?php 
        if(isset($_SESSION["id"]) && $_SESSION["account_type"] == "business" && !isset($logout)) {
            echo "<div class='menu-item' role='menuitem'>
                <a href='../business/dashboard.php'>Tableau de bord</a>
            </div>";
        }
        ?>
        <?php 
        if(isset($_SESSION["id"]) && !isset($logout)) {
            echo "<div class='menu-item' role='menuitem'>
            <a href='../common/disconnect.php'>Déconnexion</a>
            </div>";
        }
        ?>
        <div id="account-pill">
            <img id="user-logo" src="../img/user.png">
            <?php
                basename(__FILE__);
                if(isset($_SESSION["id"]) && $_SESSION["account_type"] == "customer" && !isset($logout)) {
                    $name = $_SESSION["firstname"];
                    echo "<a href='../customer/account.php'>Bonjour $name !</a>";

                } else if(isset($_SESSION["id"]) && $_SESSION["account_type"] == "business" && !isset($logout)) {
                    $name = $_SESSION["name"];
                    echo "<a href='../business/dashboard.php'>Bonjour $name !</a>";

                } else {
                    echo "<a href='../common/login.php'>Vous n'êtes pas connecté</a>";
                }
            ?>
        </div>
</nav>
<script src="../scripts/menu.js"></script>
<link rel="stylesheet" href="../style/menu.css">