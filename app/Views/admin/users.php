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
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="admin-dashboard">
  <?php include __DIR__ . '/../includes/adminSidebar.php'; ?>

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
        <tbody id="userTableBody">
          <?php foreach ($users as $user): ?>
            <tr class="user-row" data-role="<?= $user['isAdmin'] == 1 ? 'administrateur' : 'utilisateur' ?>">
              <td><?= htmlspecialchars($user['personneId']) ?></td>
              <td class="user-email"><?= htmlspecialchars($user['email']) ?></td>
              <td class="user-role"><?= $user['isAdmin'] == 1 ? 'Administrateur' : 'Utilisateur' ?></td>
              <td>
                <button class="btn-edit" data-id="<?= $user['personneId'] ?>">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn-delete" data-id="<?= $user['personneId'] ?>">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal" id="editUserModal" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <h2>Modifier l'utilisateur</h2>
      <button class="modal-close">&times;</button>
    </div>
    <div class="modal-body">
      <form id="editUserForm">
        <input type="hidden" id="userId" name="id">

        <div class="form-group">
          <label for="userEmail">Email</label>
          <input type="email" id="userEmail" name="email" required>
        </div>

        <div class="form-group">
          <label for="userRole">Rôle</label>
          <select id="userRole" name="role" required>
            <option value="utilisateur">Utilisateur</option>
            <option value="administrateur">Administrateur</option>
          </select>
        </div>

        <div class="form-group">
          <label>
            <input type="checkbox" id="deletePhoto" name="deletePhoto">
            Supprimer la photo de profil
          </label>
        </div>

        <div class="form-actions">
          <button type="button" class="btn-cancel modal-close">Annuler</button>
          <button type="submit" class="btn-save">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="/js/secureFetch.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('userSearch');
  const roleFilter = document.getElementById('roleFilter');
  const userRows = document.querySelectorAll('.user-row');
  const modal = document.getElementById('editUserModal');
  const closeModalButtons = document.querySelectorAll('.modal-close');
  const editUserForm = document.getElementById('editUserForm');

  function filterUsers() {
    const search = searchInput.value.toLowerCase();
    const role = roleFilter.value.toLowerCase();

    userRows.forEach(row => {
      const email = row.querySelector('.user-email').textContent.toLowerCase();
      const userRole = row.dataset.role.toLowerCase();

      const matchesSearch = email.includes(search);
      const matchesRole = !role || userRole === role;

      row.style.display = matchesSearch && matchesRole ? '' : 'none';
    });
  }

  searchInput.addEventListener('input', filterUsers);
  roleFilter.addEventListener('change', filterUsers);

  document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', () => {
      const row = button.closest('tr');
      document.getElementById('userId').value = button.dataset.id;
      document.getElementById('userEmail').value = row.querySelector('.user-email').textContent;
      document.getElementById('userRole').value = row.querySelector('.user-role').textContent.toLowerCase();
      document.getElementById('deletePhoto').checked = false;
      modal.style.display = 'block';
    });
  });

  closeModalButtons.forEach(button => {
    button.addEventListener('click', () => {
      modal.style.display = 'none';
    });
  });

  window.addEventListener('click', e => {
    if (e.target === modal) modal.style.display = 'none';
  });

  editUserForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(editUserForm);

    const role = formData.get('role');
    const isAdmin = role === 'administrateur' ? '1' : '0';

    formData.delete('role');
    formData.delete('deletePhoto');

    formData.set('isAdmin', isAdmin);

    const deletePhotoChecked = document.getElementById('deletePhoto').checked;
    const photoUrl = deletePhotoChecked ? null : $user["photoUrl"];
    formData.set('photoUrl', photoUrl);

    const id = formData.get('id');

    try {
        const data = {};
        formData.forEach((value, key) => {
        data[key] = value;
        });
        const response = await secureFetch(`/api/users/update?id=${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
        });

        if (response.success) {
        location.reload();
        } else {
        alert("Erreur lors de la modification");
        }
    } catch (error) {
        console.error(error);
        alert("Erreur serveur");
    }
    });


  document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', async () => {
      const userId = button.dataset.id;
      if (confirm("Supprimer cet utilisateur ?")) {
        try {
          const response = await secureFetch(`/api/users/delete?id=${userId}`, {
            method: 'DELETE',
            headers: {
                    'Content-Type': 'application/json',
                }
          });
          if (response.success) {
            button.closest('tr').remove();
          } else {
            alert("Erreur lors de la suppression");
          }
        } catch (error) {
          console.error(error);
          alert("Erreur serveur");
        }
      }
    });
  });
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
