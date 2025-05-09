<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une annonce</title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="form-container">
        <h2>Créer une nouvelle annonce</h2>
        <form action="/animalWebsite/public/index.php?page=storeAnnonce" method="POST">
        <li><a><label for="nom">Nom de l'annonce :</label></a></li>
            <li><input type="text" id="titre" name="titre" required></li>

            <li><label for="date">Date :</label></li>
            <li><input type="date" id="date" name="date" required></li>

            <li><label for="service">Service :</label></li>
            <li><input type="text" id="service" name="service" required></li>

            <li><label for="lieu">Lieu :</label></li>
            <li><input type="text" id="lieu" name="lieu" required></li>

            <li><label for="personneId">propriétaire :</label></li>
            <li><input type="number" id="personneId" name="personneId" required></li>

            <li><label for="animalId">nom de l'animal :</label></li>
            <li><input type="number" id="animalId" name="animalId" required></li>

            <li><button type="submit">Enregistrer</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
