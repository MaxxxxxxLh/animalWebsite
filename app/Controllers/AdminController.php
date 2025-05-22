<?php

namespace App\Controllers;

class AdminController {
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

    private function apiDelete(string $url): array
    {
        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'DELETE',
            ],
        ];
        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            $error = error_get_last();
            return ['error' => 'API DELETE request failed: ' . ($error['message'] ?? 'Unknown error')];
        }

        $data = json_decode($response, true);
        return is_array($data) ? $data : ['error' => 'Invalid JSON: ' . $response];
    }

    public function dashboard() {
        // Statistiques générales
        $totalUsers = $this->db->query("SELECT COUNT(*) as count FROM users")->fetch()['count'];
        $totalAnnonces = $this->db->query("SELECT COUNT(*) as count FROM annonces")->fetch()['count'];
        $recentAnnonces = $this->db->query("SELECT * FROM annonces ORDER BY created_at DESC LIMIT 5")->fetchAll();
        $newUsers = $this->db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 5")->fetchAll();
        
        // Statistiques mensuelles
        $monthlyStats = $this->db->query("
            SELECT 
                COUNT(*) as count,
                MONTH(created_at) as month 
            FROM annonces 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY MONTH(created_at)
        ")->fetchAll();

        require_once 'app/Views/admin/dashboard.php';
    }

    public function users() {
        $users = $this-> apiGet("http://localhost/api/user/findAll");
        require_once 'app/Views/admin/users.php';
    }

    public function editUser() {
        if($_SESSION['user']['isAdmin'] == 0) {
            header('Location: /');
            exit;
        }
        $email = $_POST['email'];
        $isAdmin = $_POST['idAdmin'];
        $photoUrl = $_POST['photoUrl'];
        $this -> apiPost("http://localhost/api/users/update", [
            'email' => $email,
            'isAdmin' => $isAdmin,
            'photoUrl' => $photoUrl,
        ]);
        $_SESSION['user']['isAdmin'] = $isAdmin;
        $_SESSION['user']['photoUrl'] = $photoUrl;
        header('Location: /admin/users');
        exit;
        require_once 'app/Views/admin/edit_user.php';
    }

    public function annonces() {
        $annonces = $this->apiGet("http://localhost/api/annonce/findAll");
        require_once '/../Views/admin/annonces.php';
    }

    public function analytics() {
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

        require_once 'app/Views/admin/analytics.php';
    }

    public function showUsers() {
        $users = $this->apiGet("http://localhost/api/users/findAll");
        require __DIR__ . '/../Views/admin/users.php';
    }

    public function deleteUser() {
        if($_SESSION['user']['isAdmin'] == 0) {
            header('Location: /');
            exit;
        }
        $id = $_POST['id'];
        $this->apiDelete("http://localhost/api/user/delete?id=$id");
        header('Location: /admin/users');
        exit;
    }
}