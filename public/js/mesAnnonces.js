document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('annonces-container');
    try {
        const annonces = await secureFetch(`/api/annonce/me?id=${json_encode($proprietaireId)}`);

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
            `;

            list.appendChild(card);
        }

        container.innerHTML = '';
        container.appendChild(list);
    } catch (err) {
        console.error(err);
        container.innerHTML = '<div class="error-message">Erreur lors du chargement des annonces.</div>';
    }
});
