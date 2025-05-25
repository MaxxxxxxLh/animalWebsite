<?php

namespace App\Controllers\Api;

use App\Models\Animal;

class AnimalController
{
    public function findByProprietaireId()
    {
        if (!isset($_GET['proprietaireId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing proprietaireId parameter']);
            return;
        }

        $proprietaireId = (int)$_GET['proprietaireId'];
        $animal = Animal::findByProprietaireId($proprietaireId);

        if ($animal) {
            header('Content-Type: application/json');
            echo json_encode($animal);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Animal not found']);
        }
    }

    public function exists()
    {
        if (!isset($_GET['proprietaireId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing proprietaireId parameter']);
            return;
        }

        $proprietaireId = (int)$_GET['proprietaireId'];
        $exists = Animal::existsByProprietaireId($proprietaireId);

        header('Content-Type: application/json');
        echo json_encode(['exists' => $exists]);
    }

    public function create()
    {
        $input = json_decode(file_get_contents('php://input'), true);
    
        $requiredFields = ['nom', 'age', 'type', 'informations', 'proprietaireId'];
        $missingFields = [];
    
        foreach ($requiredFields as $field) {
            if (!isset($input[$field])) {
                $missingFields[] = $field;
            }
        }
    
        if (!empty($missingFields)) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Missing parameters',
                'missing' => $missingFields
            ]);
            return;
        }
    
        $id = Animal::create(
            $input['nom'],
            (int)$input['age'],
            $input['type'],
            $input['informations'],
            (int)$input['proprietaireId']
        );
    
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'animal_id' => $id]);
    }
    
    public function findAll()
    {
        $animals = Animal::findAll();

        if ($animals) {
            header('Content-Type: application/json');
            echo json_encode($animals);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No animals found']);
        }
    }

    public function findById(){
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id parameter']);
            return;
        }

        $animalId = (int)$_GET['id'];
        $animal = Animal::findById($animalId);

        if ($animal) {
            header('Content-Type: application/json');
            echo json_encode($animal);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Animal not found']);
        }
    }

    public function update()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (
            !isset($input['nom']) || 
            !isset($input['age']) || 
            !isset($input['type']) || 
            !isset($input['informations']) || 
            !isset($input['animalId'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            return;
        }

        $success = Animal::updateAnimal(
            $input['nom'],
            (int)$input['age'],
            $input['type'],
            $input['informations'],
            (int)$input['animalId']
        );

        if ($success) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Update failed']);
        }
    }

    public function delete()
    {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id parameter']);
            return;
        }

        $id = (int)$_GET['id'];
        $animal = Animal::findById($id);

        if ($animal) {
            Animal::deleteById($id);
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Animal not found']);
        }
    }
}
