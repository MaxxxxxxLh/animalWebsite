<?php


use app\Models\User;

class AuthController
{
    // Méthode pour afficher la vue
    private function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . '/../Views/auth/' . $view . '.php';
    }

    public function login()
    {   
        include __DIR__ . '/../Views/auth/login.php';
        /*
        session_start();

        // Si l'utilisateur est déjà connecté, redirection vers la page d'accueil
        if (isset($_SESSION['user'])) {
            header("Location: /");
            exit();
        }

        // Affichage du formulaire de login
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->render('login');
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
            header("Location: /");
            exit();
        } else {
            // Rediriger ou afficher un message d'erreur détaillé
            $this->render('login', ['error' => 'Identifiants incorrects.']);
        }*/
    }

    public function register()
    {
        session_start();

        // Si l'utilisateur est déjà connecté, redirection vers la page d'accueil
        if (isset($_SESSION['user'])) {
            header("Location: /");
            exit();
        }

        // Affichage du formulaire d'inscription
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

        if (User::existsByEmail($email)) {
            die("Un compte existe déjà avec cet email.");
        }

        $userId = User::create($email, $password);

        $_SESSION['user'] = [
            'id' => $userId,
            'email' => $email,
            'isAdmin' => 0
        ];

        header("Location: /");
        exit();
    }
}
