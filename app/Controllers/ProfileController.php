<?php
namespace App\Controllers;

use App\Models\User;

class ProfileController {

    public function profile()
    {
        if (!isset($_SESSION['user']['email'])) {
            $this->redirect('/login');
        }

        $user = $_SESSION['user'];

        if (!$user) {
            $this->redirect('/profile', "Utilisateur introuvable.", "error");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = htmlspecialchars($_POST['nom'] ?? '');
            $prenom = htmlspecialchars($_POST['prenom'] ?? '');
            $photoUrl = $user['photoUrl'];
            $email = htmlspecialchars($_POST['email'] ?? $user['email']);
            $newPhoto = $this->handlePhotoUpload();
            if ($newPhoto === false) {
                $this->redirect('/profile', "Erreur lors du téléchargement de la photo.", "error");
            } elseif ($newPhoto !== null) {
                $photoUrl = $newPhoto;
            }

            if (User::updateProfile($email, $nom, $prenom, $photoUrl)) {
                $_SESSION['user']['nom'] = $nom;
                $_SESSION['user']['prenom'] = $prenom;
                $_SESSION['user']['photoUrl'] = $photoUrl;
                $this->redirect('/profile', "Profil mis à jour avec succès.", "success");
            } else {
                $this->redirect('/profile', "Erreur lors de la mise à jour du profil.", "error");
            }
        }

        $success = $_SESSION['success'] ?? null;
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['success'], $_SESSION['error']);

        require __DIR__ . '/../Views/pages/profile.php';
    }

    private function handlePhotoUpload(): string|null|false
    {
        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $fileTmp = $_FILES['photo']['tmp_name'];
        $fileName = basename($_FILES['photo']['name']);
        $uploadDir = __DIR__ . '/../../public/uploads/';
        $uploadPath = $uploadDir . $fileName;
        $photoUrl = '/uploads/' . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $fileTmp);
        finfo_close($finfo);

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($mime, $allowedTypes)) {
            return false;
        }

        if (move_uploaded_file($fileTmp, $uploadPath)) {
            return $photoUrl;
        }

        return false;
    }

    private function redirect(string $url, string $message = '', string $type = 'info'): void
    {
        if ($message) {
            $_SESSION[$type] = $message;
        }
        header("Location: $url");
        exit;
    }
}
