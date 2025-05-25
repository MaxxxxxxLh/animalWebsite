<?php

namespace App\Controllers;
use App\Utils\ApiClient;

class AnimalController {
    public function ajouterAnimal() {
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

            if (!empty($_FILES['photo']['name'])) {
                $targetDir = __DIR__ . '/../../public/uploads/';
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

            if (!$error && $proprietaireId !== null) {
                $postData = [
                    'nom' => $nom,
                    'age' => $age,
                    'type' => $type,
                    'informations' => $informations . ($photoUrl ? " | Photo: $photoUrl" : ''),
                    'proprietaireId' => $proprietaireId
                ];

                $response =  ApiClient::post("http://localhost/api/animal", $postData);

                if (isset($response['success']) && $response['success']) {
                    $success = "Animal ajouté avec succès !";
                } else {
                    $error = "Erreur lors de l'ajout de l'animal.";
                }
            }
        }

        require_once __DIR__ . '/../Views/pages/ajouter-animal.php';
    }

    public function handle() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $animalId = (int)$_POST['id'];
            $animal = ApiClient::delete("http://localhost/api/animal");
            if ($animal) {
                $isOwner = isset($_SESSION['user']['personneId']) && $_SESSION['user']['personneId'] == $animal['proprietaireId'];
                $isAdmin = isset($_SESSION['user']['isAdmin']) && $_SESSION['user']['isAdmin'] == 1;
                if ($isOwner || $isAdmin) {
                    Animal::deleteById($animalId);
                }
            }
        }
        header('Location: /mes-animaux');
        exit;
    }
}
