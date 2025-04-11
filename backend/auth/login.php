<?php
session_start();
require_once '../../database/config.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    if (empty($email) || empty($password)) {
        die("Veuillez remplir tous les champs.");
    }

    // Rechercher l'utilisateur par email
    $stmt = $pdo->prepare("SELECT * FROM Personne WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        // Authentification réussie
        $_SESSION["user"] = [
            "id" => $user["personneId"],
            "nom" => $user["nom"],
            "prenom" => $user["prenom"],
            "email" => $user["email"],
            "isAdmin" => $user["isAdmin"]
        ];
        header("Location: ../index.php");
        Exit();
    } else {
        // Mauvais identifiants
        echo "Identifiants incorrects.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>