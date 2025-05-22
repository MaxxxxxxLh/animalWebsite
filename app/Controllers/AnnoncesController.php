<?php
namespace App\Controllers;

class AnnoncesController
{
    private function apiGet(string $url): array
    {
        $response = @file_get_contents($url);
        if ($response === false) {
            $error = error_get_last();
            return ['error' => 'API GET request failed: ' . ($error['message'] ?? 'Unknown error')];
        }

        $data = json_decode($response, true);
        return is_array($data) ? $data : ['error' => 'Invalid JSON'];
    }

    private function apiPost(string $url, array $data): array
    {
        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];
        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            $error = error_get_last();
            return ['error' => 'API POST request failed: ' . ($error['message'] ?? 'Unknown error')];
        }

        $data = json_decode($response, true);
        return is_array($data) ? $data : ['error' => 'Invalid JSON: ' . $response];
    }

    public function findById()
    {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id parameter']);
            return;
        }

        $id = (int)$_GET['id'];
        $annonce = $this->apiGet("http://localhost/api/annonce?id=$id");

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

        $response = $this->apiPost("http://localhost/api/annonce", $input);

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
        $animaux = $this->apiGet("http://localhost/api/animal?proprietaireId=$proprietaireId");

        require __DIR__ . '/../Views/pages/creerAnnonces.php';
    }

    public function showAnnonces()
    {
        $annonces = $this->apiGet("http://localhost/api/annonce/all");  
        
        require __DIR__ . '/../Views/pages/annonces.php';
    }
}