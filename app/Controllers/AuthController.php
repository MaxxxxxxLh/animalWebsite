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
        $response = @file_get_contents($url);

        if ($response === false) {
            return ['error' => 'API request failed'];
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
            return ['error' => 'API POST request failed'];
        }

        $data = json_decode($response, true);
        return is_array($data) ? $data : ['error' => 'Invalid JSON'];
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
            $this->render('login', ['error' => 'Identifiants incorrects ou erreur serveur.']);
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
            $this->render('register', ['error' => "Tous les champs sont obligatoires."]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('register', ['error' => "Email invalide."]);
            return;
        }

        if ($password !== $passwordConfirmation) {
            $this->render('register', ['error' => "Les mots de passe ne correspondent pas."]);
            return;
        }

        if (strlen($password) < 8 || 
            !preg_match('/[A-Z]/', $password) || 
            !preg_match('/[a-z]/', $password) || 
            !preg_match('/[0-9]/', $password) || 
            !preg_match('/[\W]/', $password)) {
            $this->render('register', ['error' => "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial."]);
            return;
        }

        $existsData = $this->apiGet("http://localhost/api/users/exists?email=" . urlencode($email));

        if (isset($existsData['error'])) {
            $this->render('register', ['error' => "Erreur lors de la vérification de l'utilisateur."]);
            return;
        }

        if (!empty($existsData['exists'])) {
            $this->render('register', ['error' => "Un compte existe déjà avec cet email."]);
            return;
        }

        $createData = $this->apiPost("http://localhost/api/users/create", [
            'email' => $email,
            'password' => $password
        ]);

        if (!isset($createData['success']) || !$createData['success']) {
            $this->render('register', ['error' => "Erreur lors de la création du compte."]);
            return;
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

    public function forgotPassword()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->render('forgotPassword');
            return;
        }

        $email = $_POST["email"] ?? '';

        if (empty($email)) {
            die("Veuillez entrer votre adresse email.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Email invalide.");
        }

    }

    public function logout()
    {
        session_destroy();
        header("Location: /login");
        exit();
    }
}
