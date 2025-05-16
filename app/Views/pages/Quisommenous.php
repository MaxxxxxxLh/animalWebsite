<?php
// a_propos.php
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>À propos - Animal Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px auto;
            max-width: 900px;
            background-color: #fdfdfd;
            color: #333;
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
            margin-bottom: 40px;
        }

        ul {
            padding-left: 20px;
        }

        li {
            margin-bottom: 8px;
        }

        hr {
            margin: 30px 0;
            border: none;
            border-top: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <!-- Logo du site -->
    <img src="/animalWebsite/public/assets/img/logo.png" alt="Logo Animal Website" class="logo">

    <h1>À propos d'Animal Website</h1>

    <section>
        <h2>Qui sommes-nous ?</h2>
        <p>
            Animal Website est une plateforme collaborative dédiée à la publication et à la gestion d'annonces autour des animaux. Que vous soyez un particulier à la recherche d’un service ou un professionnel proposant des prestations liées aux animaux, notre site vous connecte de manière simple et intuitive.
        </p>
    </section>

    <section>
        <h2>Ce que nous faisons</h2>
        <p>Notre site permet aux utilisateurs de :</p>
        <ul>
            <li>Créer, modifier ou supprimer une annonce</li>
            <li>Rechercher et consulter des annonces publiées</li>
            <li>Refuser ou accepter une candidature à une annonce</li>
            <li>Noter la prestation reçue</li>
            <li>Créer un compte pour accéder aux fonctionnalités</li>
            <li>Utiliser une messagerie interne pour échanger avec d'autres membres</li>
        </ul>

        <p>Du côté des administrateurs, ils peuvent :</p>
        <ul>
            <li>Modérer les annonces postées par les utilisateurs</li>
            <li>Gérer les comptes utilisateurs (vérification, blocage, etc.)</li>
        </ul>
    </section>

    <section>
        <h2>Notre mission</h2>
        <p>
            Favoriser l’échange, la confiance et le respect autour du bien-être animal à travers une plateforme moderne, sécurisée et facile d’utilisation.
        </p>
    </section>

    <hr>
    <div style="text-align: center; color: #888; font-size: 0.9em;">
        &copy; <?= date('Y') ?> Animal Website – Tous droits réservés.
    </div>
</body>
</html>
