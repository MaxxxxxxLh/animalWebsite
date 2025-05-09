<!DOCTYPE html>
<html lang="fr">
<head>
    
  <meta charset="UTF-8">
  <title>Accueil - Gardiennage d'animaux</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
  <?php include_once('../includes/header.php'); ?>
  
  <main class="homepage">
    <section class="homepage-section">
      <div class="homepage-box">
        <img src="chat1.jpg" alt="Chat mangeant">
        <p>Envie de garder des animaux domestiques, de les promener ?</p>
        <a href="annonces.php" class="homepage-button">Voir les annonces disponibles</a>
      </div>
      <div class="homepage-box">
        <img src="chat2.jpg" alt="Chat mangeant">
        <p>Pas le temps de faire balader votre animal ?<br>Vous ne pouvez pas le prendre pendant vos vacances ?</p>
        <a href="creer-annonce.php" class="homepage-button">Créer votre annonce</a>
      </div>
    </section>
  </main>
  <?php include_once('../includes/footer.php'); ?>
</body>
</html>
