<?php
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}
$personneId = $_SESSION['user']['id'];
$pageTitle = 'Mes annonces';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes annonces</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pages/mesAnnonces.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include(__DIR__ . '/../includes/header.php'); ?>
<main class="container">
    <section class="form-section">
        <h2>Mes annonces</h2>
        <!-- Bouton créer annonce -->
        <div style="margin-bottom: 20px;">
            <button id="btnCreerAnnonce" class="btn btn-primary">
                <i class="fa fa-plus"></i> Créer une annonce
            </button>
        </div>

        <div id="annonces-container">
            <div class="loading-message">Chargement des annonces...</div>
        </div>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>
<script src="/js/secureFetch.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('annonces-container');

    document.getElementById('btnCreerAnnonce').addEventListener('click', () => {
        window.location.href = '/creerAnnonce';
    });

    const userId = <?= json_encode($personneId) ?>;

    async function supprimerAnnonce(id, cardElement) {
        if (!confirm("Voulez-vous vraiment supprimer cette annonce ?")) return;

        try {
            const response = await secureFetch(`/api/annonce?id=${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            if (response && response.message=="Annonce deleted successfully") {
                cardElement.remove();
            } else {
                alert("Erreur lors de la suppression de l'annonce.");
            }
        } catch (err) {
            console.error(err);
            alert("Erreur lors de la suppression de l'annonce.");
        }
    }

    try {
        const annonces = await secureFetch(`/api/annonce/me?id=${userId}`);

        if (!annonces || annonces.length === 0) {
            container.innerHTML = '<div class="error-message">Vous n\'avez publié aucune annonce pour le moment.</div>';
            return;
        }

        const list = document.createElement('div');
        list.className = 'annonces-list';

        for (const annonce of annonces) {
            const card = document.createElement('div');
            card.className = 'annonce-card';

            card.innerHTML = `
                <h3>${annonce.nom}</h3>
                <p><strong>Date :</strong> ${annonce.date}</p>
                <p><strong>Service :</strong> ${annonce.service}</p>
                <p><strong>Lieu :</strong> ${annonce.lieu}</p>
                <p><strong>Tarif :</strong> ${annonce.tarif} €</p>
                <p><strong>Description :</strong> ${annonce.description}</p>
                <p><strong>Animal associé :</strong> ${annonce.animalNom}</p>
                <button class="btn btn-danger btn-supprimer" data-id="${annonce.annonceId}">
                    <i class="fa fa-trash"></i> Supprimer
                </button>
            `;

            card.querySelector('.btn-supprimer').addEventListener('click', () => {
                supprimerAnnonce(annonce.annonceId, card);
            });

            list.appendChild(card);
        }

        container.innerHTML = '';
        container.appendChild(list);
    } catch (err) {
        console.error(err);
        container.innerHTML = '<div class="error-message">Erreur lors du chargement des annonces.</div>';
    }
});
</script>

</body>
</html>
