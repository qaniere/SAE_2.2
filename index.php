<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Coff-IT</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./style/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div id="header-container">
        <div id="account-pill">
            <img id="user-logo" src="./img/user.png">
            <?php
                if(isset($_SESSION["id"])) {
                    $name = $_SESSION["firstname"];
                    echo "<a id='pill-content' href='./customer/account.php'>Bonjour $name !</a>";

                } else {
                    echo "<a id='pill-content' href='./customer/login.php'>Vous n'êtes pas connecté</a>";
                }
            ?>
        </div>
        <div id="logo-shadow">
            <img id="logo" src="./img/logo.png" alt="Le logo de l'entreprise qui représente un ordinateur posé sur des feuilles">
        </div> 
        <div id="arrow-container">
            <div id="round">
                <a href="#content">
                    <img id="arrow" src="./img/arrow.png" alt="Une flèche qui sert à descendre dans la page">
                </a>
            </div>
        </div>
    </div>
    <div id="content">
        <div id="presentation-block">
            <h2>Qui sommes nous ?</h2>
            <p>
                Lyft hell of humblebrag organic shaman authentic, 
                selvage vegan thundercats meh cloud bread poutine pop-up gentrify bushwick. 
                Pinterest vegan yes plz irony vape hoodie blog hexagon gentrify four loko. Authentic 
                gastropub enamel pin fanny pack banjo artisan succulents. Gastropub gentrify kickstarter, 
                four loko heirloom authentic disrupt small batch +1. Pok pok stumptown pug meditation coloring 
                book tattooed twee aesthetic banh mi helvetica. Hella meggings neutra affogato, direct trade prism 
                kinfolk slow-carb migas cold-pressed ennui.
                <br>          
                <div class="button-container">
                    <a href="./common/catalog.php"><button>Voir notre catalogue</button></a>
                </div>
            </p>
        </div>
        <h3>Des offres pour les particuliers mais aussi pour les entreprises !</h3>
        <div id="customer-block-container">
            <div class="customer-block">
                <p>
                    <h3>Vous êtes un particulier</h3>
                    Lyft hell of humblebrag organic shaman authentic, 
                    selvage vegan thundercats meh cloud bread poutine pop-up gentrify bushwick. 
                    Pinterest vegan yes plz irony vape hoodie blog hexagon gentrify four loko. Authentic 
                    gastropub enamel pin fanny pack banjo artisan succulents. Gastropub gentrify kickstarter, 
                    four loko heirloom authentic disrupt small batch +1. Pok pok stumptown pug meditation coloring 
                    book tattooed twee aesthetic banh mi helvetica. Hella meggings neutra affogato, direct trade prism 
                    kinfolk slow-carb migas cold-pressed ennui.
                    <br>
                    <div class="button-container">
                        <a href="./customer/register.php"><button>S'inscrire</button></a>
                        <a href="./common/login.php"><button>Se connecter</button></a>
                    </div>      
                </p>
            </div>
            <div class="customer-block">
                <p>
                    <h3>Vous êtes une entreprise</h3>
                    Lyft hell of humblebrag organic shaman authentic, 
                    selvage vegan thundercats meh cloud bread poutine pop-up gentrify bushwick. 
                    Pinterest vegan yes plz irony vape hoodie blog hexagon gentrify four loko. Authentic 
                    gastropub enamel pin fanny pack banjo artisan succulents. Gastropub gentrify kickstarter, 
                    four loko heirloom authentic disrupt small batch +1. Pok pok stumptown pug meditation coloring 
                    book tattooed twee aesthetic banh mi helvetica. Hella meggings neutra affogato, direct trade prism 
                    kinfolk slow-carb migas cold-pressed ennui.
                    <br>
                    <div class="button-container">
                        <a href="./business/register.php"><button>S'inscrire</button> </a>
                        <a href="./common/login.php"><button>Se connecter</button></a>
                    </div> 
                </p>
            </div>
        </div>       
    </div>
    <script src="./scripts/index.js"></script>
</body>
</html>
