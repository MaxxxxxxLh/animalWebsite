<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="/css/style.css"> 
</head>
<body>

    <?php include(__DIR__ . '/../includes/header.php');?>
    <main>
        <h2>Liste des annonces</h2>
        <?php foreach ($annonces as $annonce): ?>
            <p>
                <strong>Nom :</strong> <?= $annonce['nom'] ?><br>
                <strong>Service :</strong> <?= $annonce['service'] ?><br>
                <strong>Date :</strong> <?= $annonce['date'] ?><br>
                <strong>Auteur :</strong> <?= $annonce['auteur'] ?><br>
                <strong>Animal :</strong> <?= $annonce['animal'] ?>
            </p>
            <hr>
        <?php endforeach; ?>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>