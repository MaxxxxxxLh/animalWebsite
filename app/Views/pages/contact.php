<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="contact.css">
</head>
<body>

<header>
    <!-- Ajoute ton header existant ici -->
</header>

<main>
    <h2>N'hésitez pas à nous contacter avec le formulaire ci-dessous<br>si vous avez des questions ou des remarques.</h2>

    <form action="contact_controller.php" method="POST" class="contact-form">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="email" name="mail" placeholder="Mail" required>
        <textarea name="message" placeholder="Message" rows="5" required></textarea>
        <button type="submit">Soumettre</button>
    </form>
</main>

</body>
</html>
