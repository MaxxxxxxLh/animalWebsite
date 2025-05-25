<?php

namespace App\Controllers\Api;

use App\Models\AvisUtilisateur;

class AvisController
{
    public function findByUserId()
    {
        if (!isset($_GET['userId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing userId parameter']);
            return;
        }

        $userId = (int)$_GET['userId'];
        $avis = AvisUtilisateur::findByUserId($userId);

        header('Content-Type: application/json');
        echo json_encode($avis);
    }

    public function create()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['annonceId'], $input['receveurId'], $input['envoyeurId'], $input['notes'], $input['commentaire'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            return;
        }

        $avisId = AvisUtilisateur::create(
            (int)$input['annonceId'],
            (int)$input['receveurId'],
            (int)$input['envoyeurId'],
            (int)$input['notes'],
            $input['commentaire']
        );

        if (!$avisId) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create review']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'avis_id' => $avisId
        ]);
    }

    public function findAverageNote()
    {
        if (!isset($_GET['userId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing userId parameter']);
            return;
        }

        $userId = (int)$_GET['userId'];
        $average = AvisUtilisateur::findAverageNoteForUser($userId);

        header('Content-Type: application/json');
        echo json_encode(['averageNote' => $average]);
    }
}
