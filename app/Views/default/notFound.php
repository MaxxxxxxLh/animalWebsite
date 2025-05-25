<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Page non trouvée</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    <style>
        h1 {
            font-size: 3em;
            margin-bottom: 20px;
                    }
        p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <?php include(__DIR__ . '/../includes/header.php'); ?>
    <h1 class="h1Index">404 - Page non trouvée</h1>
    <p>Désolé, la page que vous cherchez n'existe pas ou a été déplacée.</p>
    <a href="/"><button class="btn" >Retour à l'accueil</button></a>
    <?php include(__DIR__ . '/../includes/footer.php');?>
</body>
</html>
