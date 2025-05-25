<?php

namespace App\Controllers\Api;

use App\Models\User;
use DateTime;
use DateTimeZone;

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

    public function requestPasswordReset()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing email']);
            return;
        }

        $email = $input['email'];
        if (!User::existsByEmail($email)) {
            echo json_encode(['success' => true]);
            return;
        }

        $token = bin2hex(random_bytes(32));

        $expires = (new DateTime('now', new DateTimeZone('UTC')))->modify('+1 hour')->format('Y-m-d H:i:s');

        $userModel = new User();
        $saved = $userModel->savePasswordResetToken($email, $token, $expires);

        if ($saved) {

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'token' => $token]); 
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Unable to save token']);
        }
    }

    public function validateResetToken()
    {
        if (!isset($_GET['token'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing token']);
            return;
        }

        $token = $_GET['token'];
        $userModel = new User();
        $row = $userModel->findByResetToken($token);

        if (!$row) {
            http_response_code(404);
            echo json_encode(['error' => 'Invalid token']);
            return;
        }

        $expires = $row['expires'];
        $now = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
        if ($expires < $now) {
            http_response_code(410); 
            echo json_encode(['error' => 'Token expired']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'email' => $row['email']]);
    }

    public function resetPassword()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['token']) || !isset($input['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            return;
        }

        $token = $input['token'];
        $newPassword = $input['password'];

        $userModel = new User();
        $row = $userModel->findByResetToken($token);

        if (!$row) {
            http_response_code(404);
            echo json_encode(['error' => 'Invalid token']);
            return;
        }

        $expires = $row['expires'];
        $now = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
        if ($expires < $now) {
            http_response_code(410);
            echo json_encode(['error' => 'Token expired']);
            return;
        }

        $email = $row['email'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updated = $userModel->updatePassword($email, $hashedPassword);

        if ($updated) {
            $userModel->deleteResetToken($token);

            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update password']);
        }
    }
}
