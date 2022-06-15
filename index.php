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
                if(isset($_SESSION["id"]) && $_SESSION["account_type"] == "customer") {
                    $name = $_SESSION["firstname"];
                    echo "<a id='pill-content' href='./customer/account.php'>Bonjour $name !</a>";

                } else if(isset($_SESSION["id"]) && $_SESSION["account_type"] == "business") {
                    $name = $_SESSION["name"];
                    echo "<a id='pill-content' href='./business/dashboard.php'>Bonjour $name !</a>";

                } else {
                    echo "<a id='pill-content' href='./common/login.php'>Vous n'êtes pas connecté</a>";
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
        <div class="presentation-block">
            <h2 class="presentation-title">Qui sommes nous ?</h2>
            <p class="presentation-text">
                Nous sommes une jeune une start-up française qui met en relation des particuliers et des entreprises.

                Notre but est de permettre aux particuliers de trouver des entreprises qui rachètent leurs appareils
                électroniques afin d'en recycler les composants. Ces mêmes entreprises peuvent alors revendre des appareils 
                électroniques fabriqué avec les matériaux recylés aux particuliers, dans une démarche d'économie circulaire
                <br>       
            </p>
            <img class="presentation-image" src="./img/green-economy.png"> 
            <div class="button-container">
                    <a href="./common/catalog.php"><button>Voir notre catalogue</button></a>
            </div>
        </div>
        <div class="working-container">
            <img id="working-img" src="./img/working.jpg">
        </div>
        <h3>Des offres pour les particuliers mais aussi pour les entreprises !</h3>
        <div id="customer-block-container">
            <div class="customer-block">
                <p>
                    <h3>Vous êtes un particulier</h3>
                    <ul>
                        <li>Vendez vos appareils électroniques</li>
                        <li>Recevez des bon d'achat sous forme de cagnotte</li>
                        <li>Achetez des appareils électroniques grâce à cette cagnotte</li>
                        <li>Faites des économies</li>
                        <li>Faite fonctionner l'économie circulaire !</li>
                    </ul>
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
                    <ul>
                        <li>Rachetez des appareils électroniques à des clients</li>
                        <li>Récuperez des composants électroniques</li>
                        <li>Refaites des appareils électroniques avec les composants récupérés</li>
                        <li>Revendez les</li>
                        <li>Faite fonctionner l'économie circulaire !</li>
                    </ul>
                    <br>
                    <div class="button-container">
                        <a href="./business/register.php"><button>S'inscrire</button> </a>
                        <a href="./common/login.php"><button>Se connecter</button></a>
                    </div> 
                </p>
            </div>
        </div>  
        <div class="presentation-block">
            <h2 class="presentation-title">Coff-IT c'est...</h2>
            <?php
                $is_index = true;
                include_once("./include_files/db_connection.php");

                $stmt = $db->prepare("SELECT * FROM CustomerOrder");
                $stmt->execute();

                $orders = $stmt->get_result()->num_rows;

                $stmt = $db->prepare("SELECT * FROM Customer");
                $stmt->execute();

                $customers = $stmt->get_result()->num_rows;

                $stmt = $db->prepare("SELECT * FROM BusinessSell");
                $stmt->execute();

                $sales = $stmt->get_result()->num_rows;

                $stmt = $db->prepare("SELECT * FROM BusinessBuy");
                $stmt->execute();

                $buy = $stmt->get_result()->num_rows;
            ?>
            <div class="numbers">
                <div class="number-container">
                    <span class="number"><?php echo $orders ?></span>
                    <span class="description">Commandes</span>
                </div>
                <div class="number-container">
                    <span class="number"><?php echo $customers ?></span>
                    <span class="description">Clients</span>
                </div>
                <div class="number-container">
                    <span class="number"><?php echo $sales ?></span>
                    <span class="description">Objets à vendre</span>
                </div>
                <div class="number-container">
                    <span class="number"><?php echo $buy ?></span>
                    <span class="description">Objets recherchés</span>
                </div>
            </div>
        </div>     
    </div>
    <script src="./scripts/index.js"></script>
</body>
</html>
