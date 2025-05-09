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
        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%; 
            font-size: 2em; 
            cursor: pointer; 
            transform: translateY(-50%); 
        }
    </style>
</head>
<body>

<?php include(__DIR__ . '/../includes/header.php');?>

    <div class="loginContainer">
        <h2>Se connecter</h2>
        <p class="subtitle">Pas de compte? <a href="/register">Créer un compte</a></p>
        <form method="POST" action="/login">
            <div class="form-group">
                <label for="email">Votre mail</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Votre mot de passe</label>
                <input type="password" id="password" name="password" required>
                <i class="fa fa-eye eye-icon" class="eye-icon" onclick="togglePassword()">👁️</i>
                <p class="forgot-password"><a href="/forgotPassword">Mot de passe oublié</a></p>
            </div>
            <button type="submit" class="loginBtn">Se connecter</button>

            <?php if (isset($error)): ?>
                <div class="alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
        </form>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = '🙈'; 
            } else {
                passwordInput.type = 'password';
                eyeIcon.textContent = '👁️'; 
            }
        }
    </script>
</body>
</html>
