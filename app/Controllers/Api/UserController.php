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
            if (!isset($_GET['includePassword']) || $_GET['includePassword'] !== 'true') {
                unset($user['password']);
            }

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

    public function findAll()
    {
        $users = User::findAll();

        if ($users) {
            header('Content-Type: application/json');
            echo json_encode($users);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No users found']);
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
        $user = User::findById($id);

        if ($user) {
            User::delete($id);
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    public function update()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $user = User::findByEmail($input['email']);
        $email = $input['email'];
        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }
        $isAdmin = isset($input['isAdmin']) ? $input['isAdmin'] : $user['isAdmin'];
        $photoUrl = isset($input['photoUrl']) ? $input['photoUrl'] : $user['photoUrl'];
    
        if (!User::existsByEmail($input['email'])) {
            http_response_code(409);
            echo json_encode(['error' => "User doesn't exists"]);
            return;
        }
    
        User::edit($email, $isAdmin, $photoUrl);
    
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    }
    
}
