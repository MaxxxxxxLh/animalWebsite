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

    public function create()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (
            !isset($input['annonceId']) ||
            !isset($input['nom']) ||
            !isset($input['date']) ||
            !isset($input['service']) ||
            !isset($input['lieu']) ||
            !isset($input['personneId']) ||
            !isset($input['animalId'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            return;
        }

        $annonceId = (int)$input['annonceId'];
        $nom = $input['nom'];
        $date = $input['date'];
        $service = $input['service'];
        $lieu = $input['lieu'];
        $personneId = (int)$input['personneId'];
        $animalId = (int)$input['animalId'];

        $id = Annonce::create($annonceId, $nom, $date, $service, $lieu, $personneId, $animalId);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'annonce_id' => $id]);
    }
}
