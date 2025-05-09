<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="/css/style.css">
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
        <h2>Inscription</h2>
        <form method="POST" action="/register">
            <div class="form-group">
                <label for="email">Votre email</label>
                <input type="email" id="email" name="email" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="password">Votre mot de passe</label>
                <input type="password" id="password" name="password" placeholder="" required>
                <i class="fa fa-eye eye-icon" class="eye-icon" onclick="togglePassword()">👁️</i>
            </div>
            <div class="form-group">
                <label for="passwordConfirmation">Confirmez votre mot de passe</label>
                <input type="password" id="passwordConfirmation" name="passwordConfirmation" placeholder="" required>
                <i class="fa fa-eye eye-icon" class="eye-icon" onclick="togglePasswordConfirmation()">👁️</i>
            </div>
            <button type="submit" class="loginBtn">S'inscrire</button>

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
        function togglePasswordConfirmation() {
            const passwordInput = document.getElementById('passwordConfirmation');
            const eyeIcon = document.querySelector('.eye-icon');

            if (passwordInput.type === 'passwordConfirmation') {
                passwordInput.type = 'text';
                eyeIcon.textContent = '🙈'; 
            } else {
                passwordInput.type = 'passwordConfirmation';
                eyeIcon.textContent = '👁️'; 
            }
        }
    </script>
</body>
</html>
