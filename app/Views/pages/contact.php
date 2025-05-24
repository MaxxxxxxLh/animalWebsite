
<?php
// Traitement du formulaire 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && isset($_POST['mail'])) {
    if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $entete = 'MIME-Version: 1.0' . "\r\n";
        $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $entete .= 'From: webmaster@monsite.fr' . "\r\n";
        $entete .= 'Reply-to: ' . $_POST['mail'];
        
        $message = '<h1>Message envoyé depuis la page Contact de monsite.fr</h1>';
        $message .= '<p><b>Nom : </b>' . htmlspecialchars($_POST['nom']) . '<br>';
        $message .= '<b>Prénom : </b>' . htmlspecialchars($_POST['prenom']) . '<br>';
        $message .= '<b>Email : </b>' . htmlspecialchars($_POST['mail']) . '<br>';
        $message .= '<b>Message : </b>' . htmlspecialchars($_POST['message']) . '</p>';
        
        $retour = mail('destinataire@free.fr', 'Envoi depuis page Contact', $message, $entete);
        
        if($retour) {
            header('Location: /contact?success=1');
        } else {
            header('Location: /contact?success=0');
        }
        exit();
    } else {
        header('Location: /contact?success=0');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="../../../public/css/style.css"> 
</head>
<body>

<?php include(__DIR__ . '/../includes/header.php');?>
<main>
    <h2 style="text-align: center; color: #2e6531; margin-top: 50px;">
        N'hésitez pas à nous contacter avec le formulaire ci-dessous<br>si vous avez des questions ou des remarques.
    </h2>

    <form action="/contact" method="POST" class="loginContainer">
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
</main>
</body>
</html>

