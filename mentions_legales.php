<?php
// mentions_legales.php
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mentions légales</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('animaux-fond.jpg') center/cover no-repeat fixed;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        /* Ajout d'un voile blanc semi-transparent pour la lisibilité */
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: rgba(255,255,255,0.92);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 40px 30px;
            position: relative;
            z-index: 2;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 120px;
            height: auto;
            display: inline-block;
        }
        h1 {
            color: #355c36;
            border-bottom: 2px solid #355c36;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        h2 {
            color: #8eb04e;
            margin-top: 30px;
        }
        p {
            margin: 15px 0;
            line-height: 1.6;
        }
        em {
            color: #888;
        }
        .note {
            font-size: small;
            color: gray;
            margin-top: 40px;
        }
        /* Optionnel : effet de flou sur le fond avec un pseudo-élément */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: inherit;
            filter: blur(6px);
            z-index: 1;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="logo.png" alt="Logo chien et chat en cœur" class="logo">
        </div>
        <h1>Mentions légales</h1>

        <h2>Éditeur du site</h2>
        <p>
            Ce site est édité par le groupe "App" dans le cadre d’un projet scolaire à <strong>[Nom de ton école d’ingénieur]</strong>.<br>
            Ce site est un projet pédagogique fictif et ne représente pas une entité commerciale réelle.<br>
            Adresse email : contact@app-fictif.com
        </p>

        <h2>Hébergement</h2>
        <p>
            Hébergeur fictif : HébergeurExemple<br>
            Adresse : 1 rue de l'Exemple, 00000 Ville Imaginaire
        </p>

        <h2>Traitement des données</h2>
        <p>
            Aucune donnée personnelle réelle n'est collectée. Les éventuelles données affichées ou utilisées sur ce site sont purement fictives et servent uniquement à illustrer le fonctionnement du projet scolaire.
        </p>

        <h2>Propriété intellectuelle</h2>
        <p>
            Le contenu de ce site est réalisé à des fins pédagogiques et n'est pas destiné à être diffusé publiquement ou commercialisé.
        </p>

        <h2>Cookies</h2>
        <p>
            Ce site n'utilise pas de cookies à des fins de suivi ou de collecte de données personnelles.
        </p>

        <p class="note">
            Ceci est une page de mentions légales fictive réalisée pour un projet scolaire à [ISEP].
        </p>
    </div>
</body>
</html>
