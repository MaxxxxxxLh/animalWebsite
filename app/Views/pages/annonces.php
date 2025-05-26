<?php
// mentions_legales.php
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mentions légales - ISEP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px auto;
            max-width: 800px;
            background: #f9f9f9;
            color: #222;
        }
        h1, h2 {
            color: #2e8b57;
        }
        .logo {
            display: block;
            margin: 0 auto 30px auto;
            width: 120px;
            height: auto;
        }
        section {
            margin-bottom: 30px;
        }
        .subtitle {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 10px;
        }
        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <!-- Adapte le chemin du logo si besoin -->
    <img src="/animalWebsite/public/assets/img/logo.png" alt="Logo ISEP" class="logo">

    <h1>Mentions légales</h1>

    <section>
        <h2>Éditeur du site</h2>
        <div class="subtitle">Institut Supérieur d’Électronique de Paris (ISEP)</div>
        Adresse : 28 rue Notre-Dame des Champs, 75006 Paris, France<br>
        Téléphone : 01 49 54 52 00<br>
        Email : info@isep.fr<br>
        SIRET : 784 280 745 00026<br>
        Directeur de la publication : Directeur Général de l’ISEP
    </section>

    <section>
        <h2>Hébergement</h2>
        Hébergeur : acti, agence digitale basée à Lyon<br>
        Site hébergé dans un green data center par acti<br>
        Pour contacter l’hébergeur : www.acti.fr
    </section>

    <section>
        <h2>Traitement des données personnelles</h2>
        Les informations recueillies sur ce site sont enregistrées dans un fichier informatisé par l’ISEP pour la gestion des utilisateurs et des contacts.<br>
        Conformément à la loi « Informatique et Libertés » et au Règlement Général sur la Protection des Données (RGPD), vous disposez d’un droit d’accès, de rectification, d’opposition, de limitation, d’effacement et de portabilité de vos données.<br>
        Vous pouvez exercer ces droits en contactant le DPO de l’ISEP :<br>
        - Par courrier : Service DPO, 28 rue Notre-Dame des Champs, 75006 Paris<br>
        - Par mail : dpo@isep.fr
    </section>

    <section>
        <h2>Propriété intellectuelle</h2>
        L’ensemble du contenu du site (textes, images, logo, etc.) est protégé par le droit d’auteur. Toute reproduction, représentation ou diffusion, totale ou partielle, sans autorisation écrite de l’ISEP, est interdite.
    </section>

    <section>
        <h2>Cookies</h2>
        Ce site utilise des cookies pour améliorer votre expérience de navigation et réaliser des statistiques de visites. Vous pouvez configurer votre navigateur pour refuser les cookies.
    </section>

    <hr>
    <div style="text-align: center; color: #888; font-size: 0.9em;">
        &copy; <?= date('Y') ?> ISEP – Institut Supérieur d’Électronique de Paris. Tous droits réservés.
    </div>
</body>
</html>
        