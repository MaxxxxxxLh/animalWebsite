<?php
// annoncesController.php

// Connexion à la base de données
require_once '../config/database.php'; // Assure-toi que ce fichier contient ta connexion PDO

try {
    // Requête SQL pour récupérer les annonces avec jointures sur les tables liées
    $sql = "SELECT 
                a.annonceId,
                a.nom AS auteur,
                a.date,
                a.service,
                a.lieu,
                p.nom AS nom_personne,
                e.nom AS animal
            FROM Annonce a
            JOIN Personne p ON a.personneId = p.personneId
            JOIN EspeceAnimal e ON a.animalId = e.animalId
            ORDER BY a.date DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Gestion des erreurs
    die("Erreur lors de la récupération des annonces : " . $e->getMessage());
}

// Inclusion de la vue pour affichage
include '../views/annonces.php';
