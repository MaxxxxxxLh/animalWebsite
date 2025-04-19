<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
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
            </div>
            <div class="form-group">
                <label for="password">Confirmez votre mot de passe</label>
                <input type="password" id="passwordConfirmation" name="passwordConfirmation" placeholder="" required>
            </div>
            <button type="submit" class="btn">S'inscrire</button>
        </form>
    </div>
</body>
</html>
