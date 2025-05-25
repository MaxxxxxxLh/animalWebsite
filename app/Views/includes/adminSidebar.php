<?php
$currentPath = $_SERVER['REQUEST_URI'];
?>

<div class="admin-sidebar">
    <div class="admin-logo">
        <i class="fas fa-paw"></i>
        <span>Admin Panel</span>
    </div>
    <nav class="admin-nav">
        <a href="/admin/dashboard" class="<?= str_starts_with($currentPath, '/admin/dashboard') ? 'active' : '' ?>">
            <i class="fas fa-chart-line"></i>
            Tableau de bord
        </a>
        <a href="/admin/users" class="<?= str_starts_with($currentPath, '/admin/users') ? 'active' : '' ?>">
            <i class="fas fa-users"></i>
            Utilisateurs
        </a>
        <a href="/admin/annonces" class="<?= str_starts_with($currentPath, '/admin/annonces') ? 'active' : '' ?>">
            <i class="fas fa-bullhorn"></i>
            Annonces
        </a>
        <a href="/admin/analytics" class="<?= str_starts_with($currentPath, '/admin/analytics') ? 'active' : '' ?>">
            <i class="fas fa-chart-bar"></i>
            Statistiques
        </a>
    </nav>
</div>
