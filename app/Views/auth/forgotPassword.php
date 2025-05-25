<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - Gardiennage d'Animaux</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
</head>
<body>

<?php include(__DIR__ . '/../includes/header.php');?>

<div class="loginContainer">
    <h1>Mot de passe oublié</h1>
    <p class="subtitle">Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif (!empty($success)): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

        <div class="form-group">
            <label for="email">Votre mail</label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>

        <button type="submit" class="btn">Envoyer</button>
    </form>

    <p class="subtitle"><a href="/login">Retour à la connexion</a></p>
</div>

<?php include(__DIR__ . '/../includes/footer.php');?>

</body>
</html>
