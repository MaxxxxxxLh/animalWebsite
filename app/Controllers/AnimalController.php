<?php

namespace App\Controllers;

class AnimalController {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function ajouterAnimal() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $error = $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $age = intval($_POST['age'] ?? 0);
            $type = trim($_POST['type'] ?? '');
            $informations = trim($_POST['informations'] ?? '');
            $proprietaireId = $_SESSION['user']['personneId'] ?? $_SESSION['user']['id'] ?? null;
            $photoUrl = null;

            // Gestion de l'upload de la photo
            if (!empty($_FILES['photo']['name'])) {
                $targetDir = '/assets/images/';
                $fileName = uniqid('animal_') . '_' . basename($_FILES['photo']['name']);
                $targetFile = $_SERVER['DOCUMENT_ROOT'] . $targetDir . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($imageFileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                        $photoUrl = $targetDir . $fileName;
                    } else {
                        $error = "Erreur lors de l'upload de la photo.";
                    }
                } else {
                    $error = "Format de fichier non autorisé.";
                }
            }

            if (!$error) {
                $stmt = $this->db->prepare("INSERT INTO EspeceAnimal (nom, age, type, informations, proprietaireId, photoUrl) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $age, $type, $informations, $proprietaireId, $photoUrl]);
                $success = "Animal ajouté avec succès !";
            }
        }
        require_once __DIR__ . '/../Views/pages/ajouter-animal.php';
    }
}
