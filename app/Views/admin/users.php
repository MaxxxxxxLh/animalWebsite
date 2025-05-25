<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion des Utilisateurs - Admin Panel</title>
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/pages/admin.css">
<link rel="stylesheet" href="/css/footer.css">
<link rel="stylesheet" href="/css/header.css">
</head>

<?php require __DIR__ . '/../includes/header.php'; ?>

<div class="admin-dashboard">
    <?php require __DIR__ . '/../includes/adminSidebar.php'; ?>

    <div class="admin-main">
        <div class="admin-header">
            <h1>Gestion des Utilisateurs</h1>
            <div class="admin-profile">
                <a href="/logout" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>

        <div class="users-controls">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="userSearch" placeholder="Rechercher un utilisateur...">
            </div>
            <div class="filters">
                <select id="roleFilter">
                    <option value="">Tous les rôles</option>
                    <option value="administrateur">Administrateur</option>
                    <option value="utilisateur">Utilisateur</option>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['personneId']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="badge <?= $user['isAdmin'] === 1 ? 'badge-admin' : 'badge-user' ?>">
                                    <?= htmlspecialchars($user['isAdmin'] === 1 ? 'Administrateur' : 'Utilisateur') ?>
                                </span>
                            </td>
                            <td class="actions">
                                <a href="/api/users/edit/<?= $user['personneId'] ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($user['personneId'] !== $_SESSION['user']['id']): ?>
                                    <button class="btn-delete" data-id="<?= $user['personneId'] ?>">
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
    const tableRows = document.querySelectorAll('.users-table tbody tr');

    function filterTable() {
        const searchTerm = userSearch.value.toLowerCase();
        const roleValue = roleFilter.value.toLowerCase();

        tableRows.forEach(row => {
            const email = row.cells[1].textContent.toLowerCase();
            const role = row.cells[2].textContent.trim().toLowerCase();

            const matchesSearch = email.includes(searchTerm);
            const matchesRole = !roleValue || role === roleValue;

            row.style.display = matchesSearch && matchesRole ? '' : 'none';
        });
    }

    userSearch.addEventListener('input', filterTable);
    roleFilter.addEventListener('change', filterTable);

    // Gestion de la suppression
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', async function() {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                const userId = this.dataset.id;
                try {
                    const response = await fetch(`/api/users/delete?id=${userId}`, {
                        method: 'DELETE'
                    });
                    if (response.ok) {
                        this.closest('tr').remove();
                    } else {
                        alert('Une erreur est survenue lors de la suppression');
                    }
                } catch (error) {
                    console.error('Erreur: ', error);
                    alert('Une erreur est survenue');
                }
            }
        });
    });
});
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>
