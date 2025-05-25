<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gardiennage d'Animaux</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="/animalwebsite/public/assets/css/create-annonce.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">

</head>
<body class="home-page">

<?php include(__DIR__ . '/../includes/header.php');?>

    <main class="container">
        <?php
        if (isset($_SESSION["user"])) {
            $prenom = htmlspecialchars($_SESSION["user"]["prenom"]);
            $nom = htmlspecialchars($_SESSION["user"]["nom"]);
            echo "<p class='welcome-msg'>Bienvenue, $prenom $nom !</p>";
        }
        ?>
            <section class="intro"> 
            <div class="text-box">
                <h1 class="h1Index">Envie de garder des animaux ou de les promener ?</h1>
                <button class="btn">Voir les annonces</button>
            </div>
            <div class="text-box">
                <h1 class="h1Index">Pas le temps de promener votre animal ?</h1>
                <a href="/creerAnnonces"><button class="btn">Créer une annonce</button></a>
            </div>
        </section>
    </main>
    
    <?php include(__DIR__ . '/../includes/footer.php');?>
</body>
</html>
