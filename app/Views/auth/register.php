<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

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
        .password-requirements {
            font-size: 0.85em;
            margin-top: 5px;
        }
        .password-requirements span {
            display: block;
        }
        .valid {
            color: green;
        }
        .invalid {
            color: red;
        }
    </style>
</head>
<body>

<?php include(__DIR__ . '/../includes/header.php');?>

<div class="loginContainer">
    <h2>Inscription</h2>
    <form method="POST" action="/register" onsubmit="return validateForm();">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        
        <div class="form-group">
            <label for="email">Votre email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group" style="position: relative;">
            <label for="password">Votre mot de passe</label>
            <input type="password" id="password" name="password" required style="padding-right: 30px;">
            <i class="fa fa-eye eye-icon" id="eye-password" onclick="togglePassword()">👁️</i>
            <div class="password-requirements" id="password-conditions">
                <span id="length" class="invalid">✔️ Au moins 8 caractères</span>
                <span id="uppercase" class="invalid">✔️ Une majuscule</span>
                <span id="lowercase" class="invalid">✔️ Une minuscule</span>
                <span id="number" class="invalid">✔️ Un chiffre</span>
                <span id="special" class="invalid">✔️ Un caractère spécial</span>
            </div>
        </div>

        <div class="form-group" style="position: relative;">
            <label for="passwordConfirmation">Confirmez votre mot de passe</label>
            <input type="password" id="passwordConfirmation" name="passwordConfirmation" required style="padding-right: 30px;">
            <i class="fa fa-eye eye-icon" id="eye-confirm" onclick="togglePasswordConfirmation()">👁️</i>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" id="cgu" required>
                J’accepte les <a href="/cgu" target="_blank">Conditions Générales d’Utilisation</a>
            </label>
        </div>

        <button type="submit" class="loginBtn">S'inscrire</button>

        <?php if (isset($error)): ?>
            <div class="alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
    </form>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const eye = document.getElementById('eye-password');
        input.type = input.type === 'password' ? 'text' : 'password';
        eye.textContent = input.type === 'password' ? '👁️' : '🙈';
    }

    function togglePasswordConfirmation() {
        const input = document.getElementById('passwordConfirmation');
        const eye = document.getElementById('eye-confirm');
        input.type = input.type === 'password' ? 'text' : 'password';
        eye.textContent = input.type === 'password' ? '👁️' : '🙈';
    }

    function validatePasswordConditions(password) {
        return {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#\$%\^\&*\)\(+=._-]/.test(password)
        };
    }

    const passwordInput = document.getElementById('password');
    const conditions = {
        length: document.getElementById('length'),
        uppercase: document.getElementById('uppercase'),
        lowercase: document.getElementById('lowercase'),
        number: document.getElementById('number'),
        special: document.getElementById('special')
    };

    passwordInput.addEventListener('input', () => {
        const result = validatePasswordConditions(passwordInput.value);
        for (const key in result) {
            conditions[key].className = result[key] ? 'valid' : 'invalid';
        }
    });

    function validateForm() {
        const result = validatePasswordConditions(passwordInput.value);
        const allValid = Object.values(result).every(Boolean);

        if (!allValid) {
            alert("Le mot de passe ne respecte pas toutes les conditions.");
            return false;
        }

        const cguChecked = document.getElementById('cgu').checked;
        if (!cguChecked) {
            alert("Vous devez accepter les Conditions Générales d’Utilisation.");
            return false;
        }

        return true;
    }
</script>

<?php include(__DIR__ . '/../includes/footer.php');?>
</body>
</html>
