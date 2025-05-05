<?php

namespace App\Controllers;

class AuthController
{
    private function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . '/../Views/auth/' . $view . '.php';
    }

    private function apiGet(string $url): array
    {
        $response = file_get_contents($url);
        return json_decode($response, true);
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
        $response = file_get_contents($url, false, $context);

        return json_decode($response, true);
    }

    public function login()
    {

        if (isset($_SESSION['user'])) {
            header("Location: /");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->render('login');
            return;
        }

        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

        if (empty($email) || empty($password)) {
            $this->render('login', ['error' => 'Veuillez remplir tous les champs.']);
            return;
        }

        $user = $this->apiGet("http://localhost/api/users/find?email=" . urlencode($email) . "&includePassword=true");

        if (isset($user['error'])) {
            $this->render('login', ['error' => 'Identifiants incorrects.']);
            return;
        }

        if (!isset($user['password'])) {
            $this->render('login', ['error' => 'Erreur interne : mot de passe manquant.']);
            return;
        }

        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = [
                "id" => $user["personneId"],
                "nom" => $user["nom"],
                "prenom" => $user["prenom"],
                "email" => $user["email"],
                "isAdmin" => $user["isAdmin"]
            ];
            header("Location: /");
            exit();
        } else {
            $this->render('login', ['error' => 'Identifiants incorrects.']);
        }
    }

    public function register()
    {

        if (isset($_SESSION['user'])) {
            header("Location: /");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->render('register');
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

        $existsData = $this->apiGet("http://localhost/api/users/exists?email=" . urlencode($email));

        if (!empty($existsData['exists'])) {
            die("Un compte existe déjà avec cet email.");
        }

        $createData = $this->apiPost("http://localhost/api/users/create", [
            'email' => $email,
            'password' => $password
        ]);

        if (!isset($createData['success']) || !$createData['success']) {
            die("Erreur lors de la création du compte.");
        }

        $userId = $createData['user_id'];

        $_SESSION['user'] = [
            'id' => $userId,
            'email' => $email,
            'isAdmin' => 0
        ];

        header("Location: /");
        exit();
    }
}
