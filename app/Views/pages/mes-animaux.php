<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}
$pageTitle = 'Mes animaux';
$personneId = $_SESSION['user']['personneId'] ?? $_SESSION['user']['id'] ?? null;

// Récupération des animaux du propriétaire
require_once __DIR__ . '/../../Models/Animal.php';
$animaux = \App\Models\Animal::findByProprietaire($personneId);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes animaux</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/pages/creerAnnonces.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include(__DIR__ . '/../includes/header.php'); ?>
<main class="container">
    <section class="form-section">
        <h2>Mes animaux</h2>
        <a href="/ajouter-animal" class="btn-add-animal" style="margin-bottom:1.5rem;display:inline-block;">
            <i class="fas fa-plus"></i> Ajouter un animal
        </a>
        <?php if (empty($animaux)): ?>
            <div class="error-message">Vous n'avez pas encore ajouté d'animal.</div>
        <?php else: ?>
            <div class="animaux-list">
                <?php foreach ($animaux as $animal): ?>
                    <div class="animal-card">
                        <?php if (!empty($animal['photoUrl'])): ?>
                            <img src="<?= htmlspecialchars($animal['photoUrl']) ?>" alt="Photo de <?= htmlspecialchars($animal['nom']) ?>" class="animal-photo">
                        <?php endif; ?>
                        <div class="animal-info">
                            <h3><?= htmlspecialchars($animal['nom']) ?></h3>
                            <p><strong>Type :</strong> <?= htmlspecialchars($animal['type']) ?></p>
                            <p><strong>Âge :</strong> <?= htmlspecialchars($animal['age']) ?> an(s)</p>
                            <p><strong>Infos :</strong> <?= htmlspecialchars($animal['informations']) ?></p>
                        </div>
                        <?php if ((isset($_SESSION['user']['personneId']) && $_SESSION['user']['personneId'] == $animal['proprietaireId']) || (isset($_SESSION['user']['isAdmin']) && $_SESSION['user']['isAdmin'] == 1)): ?>
                        <div class="animal-actions" style="margin-top:1rem;display:flex;gap:1rem;">
                            <a href="/edit-animal?id=<?= $animal['animalId'] ?>" class="btn-edit-animal" title="Modifier"><i class="fas fa-edit"></i></a>
                            <form action="/delete-animal" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cet animal ?');">
                                <input type="hidden" name="id" value="<?= $animal['animalId'] ?>">
                                <button type="submit" class="btn-delete-animal" title="Supprimer"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>
<style>
.animaux-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}
.animal-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: box-shadow 0.2s;
}
.animal-card:hover {
    box-shadow: 0 4px 16px rgba(107,142,35,0.15);
}
.animal-photo {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 1rem;
    border: 2px solid #6b8e23;
}
.animal-info h3 {
    color: #6b8e23;
    margin-bottom: 0.5rem;
}
.animal-info p {
    margin: 0.2rem 0;
    color: #2c5530;
    font-size: 0.98rem;
}
.btn-edit-animal, .btn-delete-animal {
    background: #f5f5f5;
    border: none;
    border-radius: 6px;
    padding: 0.5rem 0.7rem;
    color: #6b8e23;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}
.btn-edit-animal:hover {
    background: #e0f7e0;
    color: #2c5530;
}
.btn-delete-animal:hover {
    background: #ffeaea;
    color: #c0392b;
}
</style>
</body>
</html>
