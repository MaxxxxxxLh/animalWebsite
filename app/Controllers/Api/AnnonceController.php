<?php

namespace App\Controllers\Api;

use App\Models\Annonce;

class AnnonceController
{
    public function findById()
    {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id parameter']);
            return;
        }

        $id = (int)$_GET['id'];
        $annonce = Annonce::findById($id);

        if ($annonce) {
            header('Content-Type: application/json');
            echo json_encode($annonce);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Annonce not found']);
        }
    }   

    public function findAll()
    {
        $annonces = Annonce::findAll();

        if ($annonces) {
            header('Content-Type: application/json');
            echo json_encode($annonces);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No annonces found']);
        }
    }

    public function create()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (
            !isset($input['nom']) ||
            !isset($input['date']) ||
            !isset($input['service']) ||
            !isset($input['lieu']) ||
            !isset($input['personneId']) ||
            !isset($input['animalId']) ||
            !isset($input['tarif']) ||
            !isset($input['description'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            return;
        }

        $nom = $input['nom'];
        $date = $input['date'];
        $service = $input['service'];   
        $lieu = $input['lieu'];
        $tarif = (int)$input['tarif'] ?? 0; 
        $description = $input['description'] ?? "";
        $personneId = (int)$input['personneId'];
        $animalId = (int)$input['animalId'];

        $id = Annonce::create($nom, $date, $service, $lieu, $tarif, $description, $personneId, $animalId);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'annonce_id' => $id]);
    }

    public function search()
    {
        $search = $_GET['search'] ?? '';
        $service = $_GET['service'] ?? '';
        $lieu = $_GET['lieu'] ?? '';
    
        $annonces = Annonce::search($search, $service, $lieu);
    
        header('Content-Type: application/json');
    
        if ($annonces && count($annonces) > 0) {
            echo json_encode($annonces);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No annonces found']);
        }
    }
    
    public function update(){
        $input = json_decode(file_get_contents('php://input'), true);

        if (
            !isset($input['id']) ||
            !isset($input['nom']) ||
            !isset($input['date']) ||
            !isset($input['service']) ||
            !isset($input['lieu']) ||
            !isset($input['tarif']) ||
            !isset($input['description'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            return;
        }

        $id = (int)$input['id'];
        $nom = $input['nom'];
        $date = $input['date'];
        $service = $input['service'];   
        $lieu = $input['lieu'];
        $tarif = (int)$input['tarif'] ?? 0; 
        $description = $input['description'] ?? "";

        Annonce::update($id, $nom, $date, $service, $lieu, $tarif, $description);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    }

    public function delete()
    {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id parameter']);
            return;
        }

        $id = (int)$_GET['id'];
        $annonce = Annonce::findById($id);

        if ($annonce) {
            Annonce::delete($id);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Annonce deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Annonce not found']);
        }
    }

}
