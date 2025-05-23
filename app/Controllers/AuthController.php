<?php

namespace App\Controllers;

use App\Utils\SecurityHelper;
use App\Utils\ApiClient;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController
{
    private function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . '/../Views/auth/' . $view . '.php';
    }

    public function login()
    {
        if (isset($_SESSION['user'])) {
            header("Location: /");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->render('login', ['csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!SecurityHelper::verifyCsrfToken($csrfToken)) {
            $this->render('login', ['error' => 'Token CSRF invalide.', 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

        if (empty($email) || empty($password)) {
            $this->render('login', ['error' => 'Veuillez remplir tous les champs.', 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        $user = ApiClient::get("http://localhost/api/users/find?email=" . urlencode($email) . "&includePassword=true");

        if (isset($user['error']) || !isset($user['password'])) {
            $this->render('login', ['error' => 'Identifiants incorrects ou erreur serveur.', 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        if (password_verify($password, $user["password"])) {
            $accessToken = SecurityHelper::generateAccessToken($user["personneId"]);
            $refreshToken = SecurityHelper::generateRefreshToken();
            SecurityHelper::storeRefreshToken($user["personneId"], $refreshToken);

            $_SESSION["user"] = [
                "id" => $user["personneId"],
                "nom" => $user["nom"],
                "prenom" => $user["prenom"],
                "email" => $user["email"],
                "isAdmin" => $user["isAdmin"],
                "photoUrl" => $user["photoUrl"] ?? null,
                "access_token" => $accessToken,
                "refresh_token" => $refreshToken
            ];

            header("Location: /");
            exit();
        } else {
            $this->render('login', ['error' => 'Identifiants incorrects.', 'csrf_token' => SecurityHelper::generateCsrfToken()]);
        }
    }

    public function register()
    {
        if (isset($_SESSION['user'])) {
            header("Location: /");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->render('register', ['csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!SecurityHelper::verifyCsrfToken($csrfToken)) {
            $this->render('register', ['error' => 'Token CSRF invalide.', 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';
        $passwordConfirmation = $_POST["passwordConfirmation"] ?? '';

        if (empty($email) || empty($password) || empty($passwordConfirmation)) {
            $this->render('register', ['error' => "Tous les champs sont obligatoires.", 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('register', ['error' => "Email invalide.", 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        if ($password !== $passwordConfirmation) {
            $this->render('register', ['error' => "Les mots de passe ne correspondent pas.", 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) ||
            !preg_match('/[0-9]/', $password) || !preg_match('/[\W]/', $password)) {
            $this->render('register', ['error' => "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.", 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        $existsData = ApiClient::get("http://localhost/api/users/exists?email=" . urlencode($email));
        if (isset($existsData['error'])) {
            $this->render('register', ['error' => "Erreur lors de la vérification de l'utilisateur.", 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        if (!empty($existsData['exists'])) {
            $this->render('register', ['error' => "Un compte existe déjà avec cet email.", 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        $createData = ApiClient::post("http://localhost/api/users/create", [
            'email' => $email,
            'password' => $password
        ]);

        if (!isset($createData['success']) || !$createData['success']) {
            $this->render('register', ['error' => "Erreur lors de la création du compte.", 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        $userId = $createData['user_id'];
        $accessToken = SecurityHelper::generateAccessToken($userId);
        $refreshToken = SecurityHelper::generateRefreshToken();
        SecurityHelper::storeRefreshToken($userId, $refreshToken);

        $_SESSION['user'] = [
            'id' => $userId,
            'email' => $email,
            'isAdmin' => 0,
            'photoUrl' => null,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];

        header("Location: /profile");
        exit();
    }
    private function sendResetPasswordEmail(string $email, string $resetLink): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';     
            $mail->SMTPAuth = true;
            $mail->Username = 'maximilien.lhote@gmail.com';
            $mail->Password = 'vfau elsc tshx rwed';    
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587;                     
            $mail->setFrom('maximilien.lhote@gmail.com', 'no-reply@animauxFascinants.com');
            $mail->addAddress($email);

            $mail->Subject = 'Reinitialisation de votre mot de passe';
            $mail->Body    = "Bonjour,\n\nPour réinitialiser votre mot de passe, cliquez sur ce lien :\n$resetLink\n\nCe lien est valide 1 heure.\n\nSi vous n'avez pas demandé cette réinitialisation, ignorez ce mail.";
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('Mail error: ' . $mail->ErrorInfo);
            echo 'Erreur d’envoi : ' . $mail->ErrorInfo; 
            return false;
        }
        
    }

    public function forgotPassword()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->render('forgotPassword', ['csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!SecurityHelper::verifyCsrfToken($csrfToken)) {
            $this->render('forgotPassword', ['error' => 'Token CSRF invalide.', 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        $email = $_POST["email"] ?? '';

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('forgotPassword', ['error' => "Email invalide.", 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        $user = ApiClient::get("http://localhost/api/users/find?email=" . urlencode($email));
        if (isset($user['error']) || !$user) {
            $this->render('forgotPassword', ['success' => "Si cet email est enregistré, vous allez recevoir un lien pour réinitialiser votre mot de passe."]);
            return;
        }

        $tokenData = ApiClient::post("http://localhost/api/users/requestPasswordReset", [
            'email' => $email
        ]);

        if (!isset($tokenData['success']) || !$tokenData['success']) {
            $this->render('forgotPassword', ['error' => "Erreur lors de la demande de réinitialisation.", 'csrf_token' => SecurityHelper::generateCsrfToken()]);
            return;
        }

        $token = $tokenData['token'] ?? null;

        if ($token) {
            $resetLink = "http://localhost:8080/resetPassword?token=" . urlencode($token);
            $emailSent = $this->sendResetPasswordEmail($email, $resetLink);

            if ($emailSent) {
                $this->render('forgotPassword', [
                    'success' => "Si cet email est enregistré, vous allez recevoir un lien pour réinitialiser votre mot de passe."
                ]);
            } else {
                $this->render('forgotPassword', [
                    'error' => "Une erreur est survenue lors de l'envoi de l'email. Veuillez réessayer plus tard."
                ]);
            }
        } else {
            $this->render('forgotPassword', [
                'error' => "Une erreur interne est survenue. Veuillez réessayer plus tard."
            ]);
        }
    }

    public function resetPassword()
    {
        $token = $_GET['token'] ?? '';
    
        $this->render('resetPassword', ['token' => $token]);
    }

    public function logout()
    {
        session_destroy();
        header("Location: /login");
        exit();
    }
}
