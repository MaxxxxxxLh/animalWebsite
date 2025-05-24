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

    public function dashboard()
    {
        $this->checkAdmin();

        $totalUsers = $this->db->query("SELECT COUNT(*) as count FROM users")->fetch()['count'];
        $totalAnnonces = $this->db->query("SELECT COUNT(*) as count FROM annonces")->fetch()['count'];
        $recentAnnonces = $this->db->query("SELECT * FROM annonces ORDER BY created_at DESC LIMIT 5")->fetchAll();
        $newUsers = $this->db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 5")->fetchAll();

        $monthlyStats = $this->db->query("
            SELECT COUNT(*) as count, MONTH(created_at) as month 
            FROM annonces 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY MONTH(created_at)
        ")->fetchAll();

        require __DIR__ . '/../Views/admin/dashboard.php';
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

    public function analytics()
    {
        $this->checkAdmin();

        $userStats = $this->db->query("
            SELECT 
                COUNT(*) as total_users,
                SUM(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) as new_users_month
            FROM users
        ")->fetch();

        $annonceStats = $this->db->query("
            SELECT 
                COUNT(*) as total_annonces,
                SUM(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) as new_annonces_month
            FROM annonces
        ")->fetch();

        require __DIR__ . '/../Views/admin/analytics.php';
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
