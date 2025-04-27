<?php

session_start();

define('DB_HOST', 'localhost');
define('DB_NAME', 'nom_de_votre_base');
define('DB_USER', 'utilisateur');
define('DB_PASS', 'mot_de_passe');

function getDB() {
    try {
        $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch(PDOException $e) {
        die('Erreur de connexion à la base de données : '.$e->getMessage());
    }
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation des données du formulaire
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $annonce_id = intval($_POST['annonce_id'] ?? 0);

    if (empty($nom)) {
        $errors[] = "Le nom est obligatoire.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email est invalide ou vide.";
    }

    if (empty($message)) {
        $errors[] = "Le message ne peut pas être vide.";
    }

    if ($annonce_id <= 0) {
        $errors[] = "L'annonce est invalide.";
    }

    if (empty($errors)) {
        try {
            $db = getDB();
            
            $stmt = $db->prepare("INSERT INTO contacts (annonce_id, nom, email, telephone, message, date_contact) 
                                 VALUES (:annonce_id, :nom, :email, :telephone, :message, NOW())");
            
            $stmt->execute([
                ':annonce_id' => $annonce_id,
                ':nom' => $nom,
                ':email' => $email,
                ':telephone' => $telephone,
                ':message' => $message
            ]);
            
            $success = true;
            
            $nom = $email = $telephone = $message = '';
            
        } catch(PDOException $e) {
            $errors[] = "Une erreur est survenue lors de l'enregistrement : ".$e->getMessage();
        }
    }
}

$annonce = null;
if (isset($_GET['id']) && $annonce_id = intval($_GET['id'])) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT a.*, u.nom AS proprietaire_nom, u.email AS proprietaire_email 
                             FROM annonces a 
                             JOIN utilisateurs u ON a.proprietaire_id = u.id 
                             WHERE a.id = :id");
        $stmt->execute([':id' => $annonce_id]);
        $annonce = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        $errors[] = "Impossible de charger l'annonce : ".$e->getMessage();
    }
}
