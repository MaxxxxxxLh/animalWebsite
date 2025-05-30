
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="/css/style.css"> 
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
</head>
<body class="contact-page">

<?php include(__DIR__ . '/../includes/header.php');?>
<main>
    <div class="contact-form">
        <h2 style="text-align: center; color: #2e6531;">
            N'hésitez pas à nous contacter avec le formulaire ci-dessous<br>si vous avez des questions ou des remarques.
        </h2>
        <form action="/contactForm" method="POST">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" required>
            </div>

            <div class="form-group">
                <label for="mail">Mail</label>
                <input type="email" name="mail" id="mail" required>
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" id="message" rows="5" required></textarea>
            </div>

        <button type="submit" class="btn">Soumettre</button>

        <?php
            if (isset($_GET['success'])) {
                if ($_GET['success'] == 1) {
                    echo '<p style="color: green; text-align: center; margin-top: 20px;">Message envoyé avec succès !</p>';
                } else {
                    echo '<p style="color: red; text-align: center; margin-top: 20px;">Erreur lors de l\'envoi du message.</p>';
                }
            }
        ?>
    </form>
    </div>
</main>
    <?php include(__DIR__ . '/../includes/footer.php');?>
</body>
</html>

