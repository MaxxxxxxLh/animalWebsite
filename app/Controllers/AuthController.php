<?php
namespace App\Controllers;

use App\Models\User;

class AuthController
{
    public function login()
    {
        session_start();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo "Méthode non autorisée.";
            return;
        }

        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

        if (empty($email) || empty($password)) {
            die("Veuillez remplir tous les champs.");
        }

        $user = User::findByEmail($email);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user"] = [
                "id" => $user["personneId"],
                "nom" => $user["nom"],
                "prenom" => $user["prenom"],
                "email" => $user["email"],
                "isAdmin" => $user["isAdmin"]
            ];
            header("Location: /"); // vers l'accueil
            exit();
        } else {
            echo "Identifiants incorrects.";
        }
    }
    public function register()
    {
        session_start();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo "Méthode non autorisée.";
            return;
        }

        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';
        $passwordConfirmation = $_POST["passwordConfirmation"] ?? '';

        if (empty($email) || empty($password) || empty($passwordConfirmation)) {
            die("Tous les champs sont obligatoires.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Email invalide.");
        }

        if ($password !== $passwordConfirmation) {
            die("Les mots de passe ne correspondent pas.");
        }

        if (User::existsByEmail($email)) {
            die("Un compte existe déjà avec cet email.");
        }

        $userId = User::create($email, $password);

        // Connexion automatique
        $_SESSION['user'] = [
            'id' => $userId,
            'email' => $email,
            'isAdmin' => 0
        ];

        header("Location: /");
        exit();
    }

}
