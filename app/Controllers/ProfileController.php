<?php
namespace App\Controllers;

use App\Models\User;

class ProfileController{
    
    public function profile()
    {
        if (!isset($_SESSION['user']['email'])) {
            header('Location: /login');
            exit;
        }

        $email = $_SESSION['user']['email'];
        $user = User::findByEmail($email);

        if (!$user) {
            $_SESSION['error'] = "Utilisateur introuvable.";
            header('Location: /profile');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $photoUrl = $user['photoUrl'];

            if (!empty($_FILES['photo']['tmp_name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/';
                $fileName = basename($_FILES['photo']['name']);
                $filePath = $uploadDir . $fileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
                    $photoUrl = '/uploads/' . $fileName;
                } else {
                    $_SESSION['error'] = "Erreur lors du téléchargement de la photo.";
                    header('Location: /profile');
                    exit;
                }
            }

            $updated = User::updateProfile($email, $nom, $prenom, $photoUrl);

            if ($updated) {
                $_SESSION['success'] = "Profil mis à jour avec succès.";
                $_SESSION['user']['nom'] = $nom;
                $_SESSION['user']['prenom'] = $prenom;
                $_SESSION['user']['photoUrl'] = $photoUrl;
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour du profil.";
            }

            header('Location: /profile');
            exit;
        }

        $success = $_SESSION['success'] ?? null;
        $error = $_SESSION['error'] ?? null;

        unset($_SESSION['success'], $_SESSION['error']);

        require __DIR__ . '/../Views/pages/profile.php';
    }

}