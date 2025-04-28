<?php

namespace App\Controllers\Api;

use App\Models\User;

class UserController
{
    public function findByEmail()
    {
        if (!isset($_GET['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing email parameter']);
            return;
        }

        $email = $_GET['email'];
        $user = User::findByEmail($email);

        if ($user) {
            unset($user['password']);
            header('Content-Type: application/json');
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    public function exists()
    {
        if (!isset($_GET['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing email parameter']);
            return;
        }

        $email = $_GET['email'];
        $exists = User::existsByEmail($email);

        header('Content-Type: application/json');
        echo json_encode(['exists' => $exists]);
    }

    public function create()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['email']) || !isset($input['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            return;
        }

        $email = $input['email'];
        $password = $input['password'];

        if (User::existsByEmail($email)) {
            http_response_code(409);
            echo json_encode(['error' => 'User already exists']);
            return;
        }

        $id = User::create($email, $password);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'user_id' => $id]);
    }
}
