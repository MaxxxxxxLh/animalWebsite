<?php
// mentions_legales.php
$pageTitle = 'Mentions légales';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions Légales - Gardiennage d'animaux</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/pages/mentions_légales.css">
</head>
<body>
    <?php include(__DIR__ . '/../includes/header.php'); ?>
    
    <main class="container">
        <section class="form-section">
            <h2>Mentions légales</h2>
            
            <h3><i class="fas fa-building"></i> Éditeur du site</h3>
            <div class="subtitle">Institut Supérieur d'Électronique de Paris (ISEP)</div>
            <p>
                <strong>Adresse :</strong> 28 rue Notre-Dame des Champs, 75006 Paris, France<br>
                <strong>Téléphone :</strong> 01 49 54 52 00<br>
                <strong>Email :</strong> <a href="mailto:info@isep.fr">info@isep.fr</a><br>
                <strong>SIRET :</strong> 784 280 745 00026<br>
                <strong>Directeur de la publication :</strong> Directeur Général de l'ISEP
            </p>

            <h3><i class="fas fa-server"></i> Hébergement</h3>
            <p>
                <strong>Hébergeur :</strong> acti, agence digitale basée à Lyon<br>
                <strong>Infrastructure :</strong> Site hébergé dans un green data center par acti<br>
                <strong>Contact hébergeur :</strong> <a href="https://www.acti.fr" target="_blank" rel="noopener">www.acti.fr</a>
            </p>

            <h3><i class="fas fa-shield-alt"></i> Traitement des données personnelles</h3>
            <p>
                Les informations recueillies sur ce site sont enregistrées dans un fichier informatisé par l'ISEP pour la gestion des utilisateurs et des contacts.
            </p>
            <p>
                Conformément à la loi « Informatique et Libertés » et au RGPD, vous disposez d'un droit d'accès, de rectification, d'opposition, de limitation, d'effacement et de portabilité de vos données.
            </p>
            <p><strong>Vous pouvez exercer ces droits en contactant le DPO de l'ISEP :</strong></p>
            <ul>
                <li><i class="fas fa-envelope"></i> <strong>Par courrier :</strong> Service DPO, 28 rue Notre-Dame des Champs, 75006 Paris</li>
                <li><i class="fas fa-at"></i> <strong>Par mail :</strong> <a href="mailto:dpo@isep.fr">dpo@isep.fr</a></li>
            </ul>

            <h3><i class="fas fa-copyright"></i> Propriété intellectuelle</h3>
            <p>
                L'ensemble du contenu du site (textes, images, logo, etc.) est protégé par le droit d'auteur. 
                <strong>Toute reproduction, représentation ou diffusion, totale ou partielle, sans autorisation écrite de l'ISEP, est interdite.</strong>
            </p>

            <h3><i class="fas fa-cookie-bite"></i> Cookies</h3>
            <p>
                Ce site utilise des cookies pour améliorer votre expérience de navigation et réaliser des statistiques de visites. 
                Vous pouvez configurer votre navigateur pour refuser les cookies ou être informé de leur envoi.
            </p>
            <p>
                Pour plus d'informations sur notre politique de cookies, consultez notre 
                <a href="/politique-confidentialite">politique de confidentialité</a>.
            </p>

            <hr>
            
            <p style="text-align: center; font-style: italic; color: #666;">
                <i class="fas fa-info-circle"></i> 
                Dernière mise à jour : <?php echo date('d/m/Y'); ?>
            </p>
        </section>
    </main>

    <?php include(__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>