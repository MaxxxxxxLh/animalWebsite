<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Réinitialisation du mot de passe - Gardiennage d'Animaux</title>
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/header.css" />
    <link rel="stylesheet" href="/css/footer.css" />
</head>
<body>
<script src="/js/resetPassword.js"></script>
<script src="/js/secureFetch.js"></script>

<?php include(__DIR__ . '/../includes/header.php'); ?>

<div class="loginContainer">
    <h1>Réinitialisation du mot de passe</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif (!empty($success)): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
        <p><a href="/login">Retour à la connexion</a></p>
    <?php endif; ?>

    <?php if (empty($success)): ?>
    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>" />
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>" />

        <div class="form-group">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" id="password" name="password" required minlength="6" />
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirmez le mot de passe</label>
            <input type="password" id="password_confirm" name="password_confirm" required minlength="6" />
        </div>

        <button type="submit" class="btn">Réinitialiser</button>
    </form>
    <?php endif; ?>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>

</body>
</html>
