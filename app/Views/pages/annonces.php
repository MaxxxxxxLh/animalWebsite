<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Annonces - Gardiennage d'animaux</title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="annonces-container">
        <h2>Liste des annonces</h2>
        
        <?php foreach ($annonces as $annonce): ?>
            <div class="annonce">
                <p>
                    <strong>Service :</strong> <?= $annonce['service'] ?><br>
                    <strong>Date :</strong> <?= $annonce['date'] ?><br>
                    <strong>Auteur :</strong> <?= $annonce['auteur'] ?><br>
                    <strong>Animal :</strong> <?= $annonce['animal'] ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>