<?php
session_start();
require_once '../../database/config.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    // Vérifie si l'utilisateur existe déjà
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Personne WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        die("Un compte existe déjà avec cet email.");
    }

    // Hasher le mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertion dans la base de données (on met isAdmin à 0 par défaut)
    $stmt = $pdo->prepare("INSERT INTO Personne (nom, prenom, email, password, isAdmin) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['', '', $email, $hashedPassword, 0]);

    // Connexion automatique
    $_SESSION['user'] = [
        'id' => $pdo->lastInsertId(),
        'email' => $email,
        'isAdmin' => 0
    ];

    header("Location: ../index.php");
    Exit();
} else {
    echo "Méthode non autorisée.";
}
?>