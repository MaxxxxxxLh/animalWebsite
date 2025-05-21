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
            <a href="/admin/users" class="active">
                <i class="fas fa-users"></i>
                Utilisateurs
            </a>
            <a href="/admin/annonces">
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
            <h1>Édition de l'utilisateur</h1>
            <div class="admin-profile">
                <span>Bienvenue, <?= htmlspecialchars($_SESSION['user']['email']) ?></span>
                <a href="/logout" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </header>

        <div class="edit-user-form">
            <form method="POST" action="/admin/users/edit/<?= $user['id'] ?>">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role">Rôle</label>
                    <div class="input-group">
                        <i class="fas fa-user-tag"></i>
                        <select id="role" name="role" <?= $user['id'] === $_SESSION['user']['id'] ? 'disabled' : '' ?>>
                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Utilisateur</option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Statut</label>
                    <div class="input-group">
                        <i class="fas fa-toggle-on"></i>
                        <select id="status" name="status" <?= $user['id'] === $_SESSION['user']['id'] ? 'disabled' : '' ?>>
                            <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Actif</option>
                            <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : '' ?>>Inactif</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="/admin/users" class="btn-cancel">
                        <i class="fas fa-times"></i>
                        Annuler
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>

        <?php if ($user['id'] !== $_SESSION['user']['id']): ?>
        <div class="danger-zone">
            <h2>Zone dangereuse</h2>
            <p>Attention : la suppression d'un utilisateur est irréversible.</p>
            <button class="btn-delete" data-id="<?= $user['id'] ?>">
                <i class="fas fa-trash"></i>
                Supprimer l'utilisateur
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.querySelector('.btn-delete')?.addEventListener('click', async function() {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')) {
        const userId = this.dataset.id;
        try {
            const response = await fetch(`/admin/users/delete/${userId}`, {
                method: 'POST'
            });
            if (response.ok) {
                window.location.href = '/admin/users';
            } else {
                alert('Une erreur est survenue lors de la suppression');
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Une erreur est survenue');
        }
    }
});
</script>

<?php require_once 'app/Views/includes/footer.php'; ?>