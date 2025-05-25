<?php
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}
$pageTitle = 'Modifier un animal';
$proprietaireId = $_SESSION['user']['id'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pages/edit-animal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include(__DIR__ . '/../includes/header.php'); ?>
<main class="container">
    <section class="form-section">
        <h2><?= $pageTitle ?></h2>
        <div id="message"></div>
        <form id="animalForm" class="animal-form">
            <div class="form-group">
                <label for="nom">Nom de l'animal</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="age">Âge</label>
                <input type="number" id="age" name="age" min="0" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="Chien">Chien</option>
                    <option value="Chat">Chat</option>
                    <option value="Oiseau">Oiseau</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="informations">Informations complémentaires</label>
                <textarea id="informations" name="informations" rows="3"></textarea>
            </div>
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Enregistrer
            </button>
        </form>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>

<script src="/js/secureFetch.js"></script>
<script>
    const animalId = new URLSearchParams(window.location.search).get('id');
    const form = document.getElementById('animalForm');
    const messageDiv = document.getElementById('message');

    async function loadAnimal() {
        try {
            const animal = await secureFetch(`/api/animal/id?id=${animalId}`);
            document.getElementById('nom').value = animal.nom;
            document.getElementById('age').value = animal.age;
            document.getElementById('type').value = animal.type;
            document.getElementById('informations').value = animal.informations || '';
        } catch (err) {
            messageDiv.innerHTML = `<div class="error-message">Erreur lors du chargement : ${err.message}</div>`;
        }
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const data = {
            nom: form.nom.value.trim(),
            age: parseInt(form.age.value, 10),
            type: form.type.value,
            informations: form.informations.value.trim(),
            animalId: animalId
        };

        try {
            await secureFetch(`/api/animal`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            messageDiv.innerHTML = `<div class="success-message">Animal modifié avec succès.</div>`;
        } catch (err) {
            messageDiv.innerHTML = `<div class="error-message">Erreur : ${err.message}</div>`;
        }
    });

    if (animalId) {
        loadAnimal();
    } else {
        messageDiv.innerHTML = `<div class="error-message">Aucun identifiant fourni.</div>`;
        form.style.display = 'none';
    }
</script>
</body>
</html>
