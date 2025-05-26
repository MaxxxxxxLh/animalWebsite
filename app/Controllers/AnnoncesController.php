<?php
namespace App\Controllers;

use App\Utils\ApiClient;

class AnnoncesController
{
    public function findById()
    {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id parameter']);
            return;
        }

        $id = (int)$_GET['id'];
        $annonce = ApiClient::get("http://localhost/api/annonce?id=$id");

        if (!isset($annonce['error'])) {
            header('Content-Type: application/json');
            echo json_encode($annonce);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Annonce not found']);
        }
    }

    public function create()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $requiredFields = ['nom', 'date', 'service', 'lieu', 'tarif', 'description', 'personneId', 'animalId'];
        foreach ($requiredFields as $field) {
            if (!isset($input[$field])) {
                http_response_code(400);
                echo json_encode(['error' => "Missing parameter: $field"]);
                return;
            }
        }

        $response = ApiClient::post("http://localhost/api/annonce", $input);

        if (!isset($response['error'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'annonce_id' => $response['annonce_id']]);
        } else {
            http_response_code(500);
            echo json_encode($response);
        }
    }

    public function showForm()
    {
        if (!isset($_SESSION['user']['email'])) {
            header('Location: /login');
            exit;
        }

        $proprietaireId = $_SESSION['user']['id'] ?? null;
        if ($proprietaireId === null) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }
        $animalExists = ApiClient::get("http://localhost/api/animal/exists?proprietaireId=$proprietaireId");
        if(!$animalExists["exists"]) {
            header('Location: /ajouter-animal');
        }
        $animaux = ApiClient::get("http://localhost/api/animal?proprietaireId=$proprietaireId");

        require __DIR__ . '/../Views/pages/creerAnnonces.php';
    }

    public function showAnnonces()
    {
        $annonces = ApiClient::get("http://localhost/api/annonce/all");  
        require __DIR__ . '/../Views/pages/annonces.php';
    }

    public function showSearchAnnonces()
    {
        $annonces = ApiClient::get("http://localhost/api/annonce/search");
    }
}
