<?php
namespace App\Controllers;

use App\Models\Animal;

class DeleteAnimalController {
    public function handle() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $animalId = (int)$_POST['id'];
            $animal = Animal::findById($animalId);
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
