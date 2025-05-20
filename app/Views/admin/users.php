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
            <h1>Gestion des Utilisateurs</h1>
            <div class="admin-profile">
                <span>Bienvenue, <?= htmlspecialchars($_SESSION['user']['email']) ?></span>
                <a href="/logout" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </header>

        <div class="users-controls">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="userSearch" placeholder="Rechercher un utilisateur...">
            </div>
            <div class="filters">
                <select id="roleFilter">
                    <option value="">Tous les rôles</option>
                    <option value="admin">Admin</option>
                    <option value="user">Utilisateur</option>
                </select>
                <select id="statusFilter">
                    <option value="">Tous les statuts</option>
                    <option value="active">Actif</option>
                    <option value="inactive">Inactif</option>
                </select>
            </div>
        </div>

        <div class="users-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="badge <?= $user['role'] === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                                    <?= htmlspecialchars($user['role']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= $user['status'] === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                    <?= htmlspecialchars($user['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                            <td class="actions">
                                <a href="/admin/users/edit/<?= $user['id'] ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($user['id'] !== $_SESSION['user']['id']): ?>
                                    <button class="btn-delete" data-id="<?= $user['id'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userSearch = document.getElementById('userSearch');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    const tableRows = document.querySelectorAll('.users-table tbody tr');

    function filterTable() {
        const searchTerm = userSearch.value.toLowerCase();
        const roleValue = roleFilter.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();

        tableRows.forEach(row => {
            const email = row.cells[1].textContent.toLowerCase();
            const role = row.cells[2].textContent.trim().toLowerCase();
            const status = row.cells[3].textContent.trim().toLowerCase();

            const matchesSearch = email.includes(searchTerm);
            const matchesRole = !roleValue || role === roleValue;
            const matchesStatus = !statusValue || status === statusValue;

            row.style.display = matchesSearch && matchesRole && matchesStatus ? '' : 'none';
        });
    }

    userSearch.addEventListener('input', filterTable);
    roleFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);

    // Gestion de la suppression
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', async function() {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                const userId = this.dataset.id;
                try {
                    const response = await fetch(`/admin/users/delete/${userId}`, {
                        method: 'POST'
                    });
                    if (response.ok) {
                        this.closest('tr').remove();
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