<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gardiennage d'Animaux</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-top: 15px;   
            border-radius: 4px;
            font-size: 0.95em;
        }
    </style>
</head>
<body>

<?php include(__DIR__ . '/../includes/header.php');?>

    <div class="loginContainer">
        <h1>Se connecter</h1>
        <p class="subtitle">Pas de compte? <a href="/register">Créer un compte</a></p>
        <form method="POST" action="/login">
            <div class="form-group">
                <label for="email">Votre mail</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Votre mot de passe</label>
                <input type="password" id="password" name="password" required>
                <p class="forgot-password"><a href="/forgotPassword.php">Mot de passe oublié</a></p>
            </div>
            <button type="submit" class="btn">Se connecter</button>
        </form>
    </div>
</body>
</html>
