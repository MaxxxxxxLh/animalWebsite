<?php

namespace App\Controllers;

use App\Utils\ApiClient;

class AdminController {

    private function checkAdmin()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['isAdmin'] ?? 0) == 0) {
            header('Location: /');
            exit;
        }
    }


    public function users()
    {
        $this->checkAdmin();

        $users = ApiClient::get("http://localhost/api/user/findAll");
        require __DIR__ . '/../Views/admin/users.php';
    }

    public function editUser()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            echo "CSRF token invalid.";
            exit;
        }

        $email = $_POST['email'] ?? '';
        $isAdmin = $_POST['idAdmin'] ?? 0;
        $photoUrl = $_POST['photoUrl'] ?? '';

        $response = ApiClient::post("http://localhost/api/users/update", [
            'email' => $email,
            'isAdmin' => $isAdmin,
            'photoUrl' => $photoUrl,
        ]);

        if (!isset($response['error'])) {
            $_SESSION['user']['isAdmin'] = $isAdmin;
            $_SESSION['user']['photoUrl'] = $photoUrl;
        }

        header('Location: /admin/users');
        exit;
    }

    public function annonces()
    {
        $this->checkAdmin();

        $annonces = ApiClient::get("http://localhost/api/annonce/all");
        require __DIR__ . '/../Views/admin/annonces.php';
    }

    public function showUsers()
    {
        $this->checkAdmin();

        $users = ApiClient::get("http://localhost/api/users/findAll");
        require __DIR__ . '/../Views/admin/users.php';
    }

    public function deleteUser()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            echo "CSRF token invalid.";
            exit;
        }

        $id = $_POST['id'] ?? null;

        if ($id !== null) {
            ApiClient::delete("http://localhost/api/user/delete?id=$id");
        }

        header('Location: /admin/users');
        exit;
    }
    public function deleteAnnonce()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            echo "CSRF token invalid.";
            exit;
        }

        $id = $_POST['id'] ?? null;

        if ($id !== null) {
            ApiClient::delete("http://localhost/api/annonce/delete?id=$id");
        }

        header('Location: /admin/annonces');
        exit;
    }
}
