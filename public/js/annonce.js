document.querySelector('.search-form').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = e.target;
    const params = new URLSearchParams(new FormData(form)).toString();

    console.log(params)
    try {
        const data = await secureFetch(`/api/annonce/search?${params}`, 
            { 
                method: 'GET',
                headers: { "Content-Type": "application/json" },
            });
            

        const container = document.querySelector('.annonces-grid');
        container.innerHTML = '';

        if (data.length === 0) {
            container.innerHTML = `
                <div class="no-results">
                    <i class="fas fa-info-circle"></i>
                    <p>Aucune annonce ne correspond à votre recherche.</p>
                </div>
            `;
            return;
        }

        data.forEach(annonce => {
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
});
