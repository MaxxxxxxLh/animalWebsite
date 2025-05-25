<?php
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}
$pageTitle = 'Mes animaux';
$proprietaireId = $_SESSION['user']['id'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes animaux</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pages/mesAnimaux.css">
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
        <div id="animaux-container">
            <div class="loading-message">Chargement des animaux...</div>
        </div>
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
.error-message {
    color: #c0392b;
    background: #ffeaea;
    padding: 1rem;
    border-radius: 8px;
    text-align: center;
}
</style>
<script src="/js/secureFetch.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('animaux-container');
    try {
        const animaux = await secureFetch(`/api/animal?proprietaireId=${<?= json_encode($proprietaireId) ?>}`);
        if (!animaux || animaux.length === 0) {
            container.innerHTML = '<div class="error-message">Vous n\'avez pas encore ajouté d\'animal.</div>';
            return;
        }

        const list = document.createElement('div');
        list.className = 'animaux-list';

        for (const animal of animaux) {
            const card = document.createElement('div');
            card.className = 'animal-card';

            if (animal.photoUrl) {
                const img = document.createElement('img');
                img.src = animal.photoUrl;
                img.alt = 'Photo de ' + animal.nom;
                img.className = 'animal-photo';
                card.appendChild(img);
            }

            const info = document.createElement('div');
            info.className = 'animal-info';
            info.innerHTML = `
                <h3>${animal.nom}</h3>
                <p><strong>Type :</strong> ${animal.type}</p>
                <p><strong>Âge :</strong> ${animal.age} an(s)</p>
                <p><strong>Infos :</strong> ${animal.informations}</p>
            `;
            card.appendChild(info);

            const editBtn = document.createElement('a');
            editBtn.href = '/edit-animal?id=' + animal.animalId;
            editBtn.className = 'btn-edit-animal';
            editBtn.title = 'Modifier cet animal';
            editBtn.style = 'margin-top: 1rem;';
            editBtn.innerHTML = '<i class="fas fa-edit"></i> Modifier';
            card.appendChild(editBtn);

            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'btn-delete-animal';
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i> Supprimer';
            deleteBtn.style = 'margin-top: 0.5rem;';
            deleteBtn.onclick = async () => {
                if (!confirm('Supprimer cet animal ?')) return;

                try {
                    const url = `/api/animal?id=${encodeURIComponent(animal.animalId)}`;
                    const res = await secureFetch(url, {
                        method: 'DELETE'
                    });

                    if (res && res.success) {
                        card.remove();
                    } else {
                        alert('Erreur lors de la suppression de l\'animal.');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Une erreur est survenue lors de la suppression.');
                }
            };
            card.appendChild(deleteBtn);

            list.appendChild(card);
        }

        container.innerHTML = '';
        container.appendChild(list);
    } catch (err) {
        container.innerHTML = '<div class="error-message">Erreur lors du chargement des animaux.</div>';
        console.error(err);
    }
});
</script>
</body>
</html>
