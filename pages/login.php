<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gardiennage d'Animaux</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="loginContainer">
        <h1>Se connecter</h1>
        <p class="subtitle">Pas de compte? <a href="signup.html">Créer un compte</a></p>
        <form>
            <div class="form-group">
                <label for="email">Votre mail</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Votre mot de passe</label>
                <input type="password" id="password" name="password" required>
                <p class="forgot-password"><a href="forgotPassword.html">Mot de passe oublié</a></p>
            </div>
            <button type="submit" class="btn">Se connecter</button>
        </form>
    </div>
</body>
</html>
