document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.search-form');
    const container = document.querySelector('.annonces-grid');
    if (!form || !container) return;

    async function fetchAndDisplayAnnonces() {
        const params = new URLSearchParams(new FormData(form)).toString();

        try {
            const data = await secureFetch(`/api/annonce/search?${params}`, {
                method: 'GET',
                headers: { "Content-Type": "application/json" },
            });

            container.innerHTML = '';
            const annoncesFiltrees = data.filter(annonce => annonce.personneId !== userId);

            if (!annoncesFiltrees || annoncesFiltrees.length === 0) {
                container.innerHTML = `
                    <div class="no-results">
                        <i class="fas fa-info-circle"></i>
                        <p>Aucune annonce ne correspond à votre recherche.</p>
                    </div>
                `;
                return;
            }

            annoncesFiltrees.forEach(annonce => {
                const html = `
                    <div class="annonce-card">
                        <div class="annonce-header">
                            <h3>${annonce.nom}</h3>
                            <span class="service-tag">${annonce.service}</span>
                        </div>
                        <div class="annonce-content">
                            <p class="annonce-description">${annonce.description || ''}</p>
                            <div class="annonce-details">
                                <div class="detail"><i class="fas fa-map-marker-alt"></i> <span>${annonce.lieu}</span></div>
                                <div class="detail"><i class="fas fa-calendar"></i> <span>${(new Date(annonce.date)).toLocaleDateString()}</span></div>
                                <div class="detail"><i class="fas fa-paw"></i> <span>${annonce.animalId}</span></div>
                                <div class="detail"><i class="fas fa-user"></i> <span>${annonce.personneId}</span></div>
                            </div>
                        </div>
                        <div class="annonce-footer">
                            <button class="btn-contact" onclick="openConversation(${userId}, ${annonce.personneId})">
                                <i class="fas fa-envelope"></i> Contacter
                            </button>
                            <a class="btn-rate" href="/noter-utilisateur?userId=${annonce.personneId}&annonceId=${annonce.annonceId}">
                                <i class="fas fa-star"></i> Noter
                            </a>
                            ${annonce.tarif ? `
                                <div class="tarif">
                                    <i class="fas fa-tag"></i>
                                    <span>${parseFloat(annonce.tarif).toFixed(2)} €</span>
                                </div>` : ''}
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', html);
            });

        } catch (err) {
            alert('Erreur lors de la récupération des annonces : ' + err.message);
        }
    }

    fetchAndDisplayAnnonces();

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        fetchAndDisplayAnnonces();
    });
});
