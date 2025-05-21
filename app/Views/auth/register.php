<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
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
            top: 65%;
            transform: translateY(-50%);
            font-size: 2em;
            cursor: pointer;
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
            <div class="form-group" style="position: relative;">
                <label for="password">Votre mot de passe</label>
                <input type="password" id="password" name="password" required style="padding-right: 30px;">
                <i class="fa fa-eye eye-icon" id="eye-password" onclick="togglePassword()">👁️</i>
            </div>
            <div class="form-group" style="position: relative;">
                <label for="passwordConfirmation">Confirmez votre mot de passe</label>
                <input type="password" id="passwordConfirmation" name="passwordConfirmation" required style="padding-right: 30px;">
                <i class="fa fa-eye eye-icon" id="eye-confirm" onclick="togglePasswordConfirmation()">👁️</i>
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
        const eyeIcon = document.getElementById('eye-password');

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
        const eyeIcon = document.getElementById('eye-confirm');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.textContent = '🙈';
        } else {
            passwordInput.type = 'password';
            eyeIcon.textContent = '👁️';
        }
    }
</script>

<?php include(__DIR__ . '/../includes/footer.php');?>
</body>
</html>
