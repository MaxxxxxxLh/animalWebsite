<?php
namespace App\Controllers;

use App\Models\User;

class ProfileController
{
    public function profile()
    {

        if (!isset($_SESSION['user']['email'])) {
            header('Location: /login');
            exit;
        }

        $email = $_SESSION['user']['email'];
        $user = User::findByEmail($email);

        if (!$user) {
            $error = "Utilisateur introuvable.";
            require __DIR__ . '/../Views/pages/profile.php';
            return;
        }

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
                $error = "Erreur lors du téléchargement de la photo.";
                require __DIR__ . '/../Views/pages/profile.php';
                return;
            }
        }

        $updated = User::updateProfile($email, $nom, $prenom, $photoUrl);

        if ($updated) {
            $user['nom'] = $nom;
            $user['prenom'] = $prenom;
            $user['photoUrl'] = $photoUrl;
            $success = "Profil mis à jour avec succès.";
        } else {
            $error = "Erreur lors de la mise à jour du profil.";
        }

        require __DIR__ . '/../Views/pages/profile.php';
    }
}
