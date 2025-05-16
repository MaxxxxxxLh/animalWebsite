<?php require_once 'app/Views/includes/header.php'; ?>

<div class="admin-dashboard">
    <div class="admin-sidebar">
        <div class="admin-logo">
            <i class="fas fa-paw"></i>
            <span>Admin Panel</span>
        </div>
        <nav class="admin-nav">
            <a href="/admin/dashboard">
                <i class="fas fa-chart-line"></i>
                Tableau de bord
            </a>
            <a href="/admin/users">
                <i class="fas fa-users"></i>
                Utilisateurs
            </a>
            <a href="/admin/annonces" class="active">
                <i class="fas fa-bullhorn"></i>
                Annonces
            </a>
            <a href="/admin/analytics">
                <i class="fas fa-chart-bar"></i>
                Statistiques
            </a>
        </nav>
    </div>

    <div class="admin-main">
        <header class="admin-header">
            <h1>Gestion des Annonces</h1>
            <div class="admin-profile">
                <span>Bienvenue, <?= htmlspecialchars($_SESSION['user']['email']) ?></span>
                <a href="/logout" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </header>

        <div class="annonces-controls">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="annonceSearch" placeholder="Rechercher une annonce...">
            </div>
            <div class="filters">
                <select id="statusFilter">
                    <option value="">Tous les statuts</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">En attente</option>
                </select>
                <select id="categoryFilter">
                    <option value="">Toutes les catégories</option>
                    <option value="chien">Chien</option>
                    <option value="chat">Chat</option>
                    <option value="oiseau">Oiseau</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
        </div>

        <div class="annonces-grid">
            <?php foreach ($annonces as $annonce): ?>
            <div class="annonce-card" data-status="<?= htmlspecialchars($annonce['status']) ?>" data-category="<?= htmlspecialchars($annonce['category']) ?>">
                <div class="annonce-header">
                    <span class="badge <?= $annonce['status'] === 'active' ? 'badge-active' : ($annonce['status'] === 'pending' ? 'badge-pending' : 'badge-inactive') ?>">
                        <?= htmlspecialchars($annonce['status']) ?>
                    </span>
                    <div class="annonce-actions">
                        <button class="btn-edit" data-id="<?= $annonce['id'] ?>">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-delete" data-id="<?= $annonce['id'] ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <div class="annonce-image">
                    <img src="<?= htmlspecialchars($annonce['image_url']) ?>" alt="<?= htmlspecialchars($annonce['title']) ?>">
                </div>

                <div class="annonce-content">
                    <h3><?= htmlspecialchars($annonce['title']) ?></h3>
                    <p class="annonce-category">
                        <i class="fas fa-tag"></i>
                        <?= htmlspecialchars($annonce['category']) ?>
                    </p>
                    <p class="annonce-description"><?= htmlspecialchars(substr($annonce['description'], 0, 100)) ?>...</p>
                    <div class="annonce-meta">
                        <span>
                            <i class="fas fa-user"></i>
                            <?= htmlspecialchars($annonce['user_email']) ?>
                        </span>
                        <span>
                            <i class="fas fa-calendar"></i>
                            <?= date('d/m/Y', strtotime($annonce['created_at'])) ?>
                        </span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Modal d'édition -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Modifier l'annonce</h2>
            <button class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editAnnonceForm">
                <input type="hidden" id="annonceId" name="id">
                
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="category">Catégorie</label>
                    <select id="category" name="category" required>
                        <option value="chien">Chien</option>
                        <option value="chat">Chat</option>
                        <option value="oiseau">Oiseau</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Statut</label>
                    <select id="status" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">En attente</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel modal-close">Annuler</button>
                    <button type="submit" class="btn-save">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const annonceSearch = document.getElementById('annonceSearch');
    const statusFilter = document.getElementById('statusFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const annonceCards = document.querySelectorAll('.annonce-card');
    const modal = document.getElementById('editModal');

    // Filtrage des annonces
    function filterAnnonces() {
        const searchTerm = annonceSearch.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        const categoryValue = categoryFilter.value.toLowerCase();

        annonceCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const description = card.querySelector('.annonce-description').textContent.toLowerCase();
            const status = card.dataset.status.toLowerCase();
            const category = card.dataset.category.toLowerCase();

            const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            const matchesStatus = !statusValue || status === statusValue;
            const matchesCategory = !categoryValue || category === categoryValue;

            card.style.display = matchesSearch && matchesStatus && matchesCategory ? '' : 'none';
        });
    }

    annonceSearch.addEventListener('input', filterAnnonces);
    statusFilter.addEventListener('change', filterAnnonces);
    categoryFilter.addEventListener('change', filterAnnonces);

    // Gestion du modal
    const editButtons = document.querySelectorAll('.btn-edit');
    const closeButtons = document.querySelectorAll('.modal-close');
    const editForm = document.getElementById('editAnnonceForm');

    editButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const annonceId = this.dataset.id;
            const card = this.closest('.annonce-card');
            
            // Remplir le formulaire avec les données de l'annonce
            document.getElementById('annonceId').value = annonceId;
            document.getElementById('title').value = card.querySelector('h3').textContent;
            document.getElementById('description').value = card.querySelector('.annonce-description').textContent.slice(0, -3); // Enlever les "..."
            document.getElementById('category').value = card.dataset.category;
            document.getElementById('status').value = card.dataset.status;

            modal.style.display = 'block';
        });
    });

    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Gestion du formulaire d'édition
    editForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        try {
            const response = await fetch(`/admin/annonces/edit/${formData.get('id')}`, {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                location.reload();
            } else {
                alert('Une erreur est survenue lors de la modification');
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Une erreur est survenue');
        }
    });

    // Gestion de la suppression
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', async function() {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')) {
                const annonceId = this.dataset.id;
                try {
                    const response = await fetch(`/admin/annonces/delete/${annonceId}`, {
                        method: 'POST'
                    });
                    if (response.ok) {
                        this.closest('.annonce-card').remove();
                    } else {
                        alert('Une erreur est survenue lors de la suppression');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue');
                }
            }
        });
    });
});
</script>

<?php require_once 'app/Views/includes/footer.php'; ?>