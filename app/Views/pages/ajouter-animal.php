<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}
$pageTitle = 'Ajouter un animal';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un animal</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pages/creerAnnonces.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include(__DIR__ . '/../includes/header.php'); ?>

<main class="container">
    <section class="form-section">
        <h2>Ajouter un animal</h2>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form action="/ajouter-animal" method="POST" enctype="multipart/form-data" class="animal-form">
            <div class="form-group">
                <label for="nom">Nom de l'animal</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="age">Âge</label>
                <input type="number" id="age" name="age" min="0" value="<?= htmlspecialchars($_POST['age'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="">Sélectionner</option>
                    <option value="Chien" <?= (($_POST['type'] ?? '') === 'Chien') ? 'selected' : '' ?>>Chien</option>
                    <option value="Chat" <?= (($_POST['type'] ?? '') === 'Chat') ? 'selected' : '' ?>>Chat</option>
                    <option value="Oiseau" <?= (($_POST['type'] ?? '') === 'Oiseau') ? 'selected' : '' ?>>Oiseau</option>
                    <option value="Autre" <?= (($_POST['type'] ?? '') === 'Autre') ? 'selected' : '' ?>>Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="informations">Informations complémentaires</label>
                <textarea id="informations" name="informations" rows="3"><?= htmlspecialchars($_POST['informations'] ?? '') ?></textarea>
            </div>
            <div class="form-group">
                <label for="photo">Photo de l'animal</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>
            <button type="submit" class="btn-submit">
                <i class="fas fa-plus"></i> Ajouter l'animal
            </button>
        </form>
    </section>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>
