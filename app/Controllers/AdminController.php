<?php

namespace App\Controllers;

class AdminController {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
        
        // Vérification si l'utilisateur est admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }
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
        $users = $this->db->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
        require_once 'app/Views/admin/users.php';
    }

    public function editUser($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $role = $_POST['role'];
            $status = $_POST['status'];
            
            $this->db->prepare("
                UPDATE users 
                SET email = ?, role = ?, status = ? 
                WHERE id = ?
            ")->execute([$email, $role, $status, $id]);
            
            header('Location: /admin/users');
            exit;
        }

        $user = $this->db->prepare("SELECT * FROM users WHERE id = ?")->execute([$id])->fetch();
        require_once 'app/Views/admin/edit_user.php';
    }

    public function annonces() {
        $annonces = $this->db->query("SELECT * FROM annonces ORDER BY created_at DESC")->fetchAll();
        require_once 'app/Views/admin/annonces.php';
    }

    public function analytics() {
        // Statistiques détaillées
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
}