document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('annonceForm');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const data = {
            nom: document.getElementById('titre').value,
            date: document.getElementById('date').value,
            service: document.getElementById('service').value,
            lieu: document.getElementById('lieu').value,
            tarif: document.getElementById('tarif').value,
            description: document.getElementById('description').value,
            personneId: proprietaireId,
            animalId: document.getElementById('animalId').value
        };

        try {
            const result = await secureFetch('/api/annonce', {
                method: 'POST',
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });

            if (result.success) {
                window.location.href = "/";
            } else {
                alert("Erreur: " + (result.error || "Une erreur inconnue"));
            }
        } catch (err) {
            alert("Erreur lors de l'envoi des données: " + err.message);
        }
    });
});