<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}
require_once __DIR__ . '/../../Models/Animal.php';
$animal = null;
$error = $success = '';
if (isset($_GET['id'])) {
    $animal = \App\Models\Animal::findById((int)$_GET['id']);
    if (!$animal) {
        $error = "Animal introuvable.";
    }
} else {
    $error = "Aucun animal sélectionné.";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $animal) {
    $nom = trim($_POST['nom'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $type = trim($_POST['type'] ?? '');
    $informations = trim($_POST['informations'] ?? '');
    if ($nom && $age && $type) {
        \App\Models\Animal::updateById($animal['animalId'], $nom, $age, $type, $informations);
        $success = "Animal modifié avec succès.";
        $animal = \App\Models\Animal::findById($animal['animalId']);
    } else {
        $error = "Tous les champs obligatoires doivent être remplis.";
    }
}
$pageTitle = 'Modifier un animal';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un animal</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/pages/creerAnnonces.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include(__DIR__ . '/../includes/header.php'); ?>
<main class="container">
    <section class="form-section">
        <h2>Modifier un animal</h2>
        <?php if ($error): ?><div class="error-message"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <?php if ($success): ?><div class="success-message"><?= htmlspecialchars($success) ?></div><?php endif; ?>
        <?php if ($animal): ?>
        <form action="?id=<?= $animal['animalId'] ?>" method="POST" class="animal-form">
            <div class="form-group">
                <label for="nom">Nom de l'animal</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($animal['nom']) ?>" required>
            </div>
            <div class="form-group">
                <label for="age">Âge</label>
                <input type="number" id="age" name="age" min="0" value="<?= htmlspecialchars($animal['age']) ?>" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="Chien" <?= $animal['type'] === 'Chien' ? 'selected' : '' ?>>Chien</option>
                    <option value="Chat" <?= $animal['type'] === 'Chat' ? 'selected' : '' ?>>Chat</option>
                    <option value="Oiseau" <?= $animal['type'] === 'Oiseau' ? 'selected' : '' ?>>Oiseau</option>
                    <option value="Autre" <?= $animal['type'] === 'Autre' ? 'selected' : '' ?>>Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="informations">Informations complémentaires</label>
                <textarea id="informations" name="informations" rows="3"><?= htmlspecialchars($animal['informations']) ?></textarea>
            </div>
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Enregistrer
            </button>
        </form>
        <?php endif; ?>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>
