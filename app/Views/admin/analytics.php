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
            <a href="/admin/annonces">
                <i class="fas fa-bullhorn"></i>
                Annonces
            </a>
            <a href="/admin/analytics" class="active">
                <i class="fas fa-chart-bar"></i>
                Statistiques
            </a>
        </nav>
    </div>

    <div class="admin-main">
        <header class="admin-header">
            <h1>Statistiques détaillées</h1>
            <div class="admin-profile">
                <span>Bienvenue, <?= htmlspecialchars($_SESSION['user']['email']) ?></span>
                <a href="/logout" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </header>

        <div class="analytics-grid">
            <div class="analytics-card">
                <h3>Croissance des utilisateurs</h3>
                <div class="stats-summary">
                    <div class="stat-item">
                        <span class="stat-label">Total</span>
                        <span class="stat-value"><?= $userStats['total_users'] ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Nouveaux (30j)</span>
                        <span class="stat-value"><?= $userStats['new_users_month'] ?></span>
                        <span class="stat-trend <?= $userStats['new_users_month'] > 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-arrow-<?= $userStats['new_users_month'] > 0 ? 'up' : 'down' ?>"></i>
                        </span>
                    </div>
                </div>
                <canvas id="userGrowthChart"></canvas>
            </div>

            <div class="analytics-card">
                <h3>Activité des annonces</h3>
                <div class="stats-summary">
                    <div class="stat-item">
                        <span class="stat-label">Total</span>
                        <span class="stat-value"><?= $annonceStats['total_annonces'] ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Nouvelles (30j)</span>
                        <span class="stat-value"><?= $annonceStats['new_annonces_month'] ?></span>
                        <span class="stat-trend <?= $annonceStats['new_annonces_month'] > 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-arrow-<?= $annonceStats['new_annonces_month'] > 0 ? 'up' : 'down' ?>"></i>
                        </span>
                    </div>
                </div>
                <canvas id="annonceActivityChart"></canvas>
            </div>

            <div class="analytics-card full-width">
                <h3>Vue d'ensemble des performances</h3>
                <div class="performance-metrics">
                    <div class="metric-group">
                        <h4>Engagement utilisateurs</h4>
                        <div class="metric-list">
                            <div class="metric-item">
                                <i class="fas fa-users"></i>
                                <div class="metric-details">
                                    <span class="metric-value"><?= $userStats['total_users'] ?></span>
                                    <span class="metric-label">Utilisateurs actifs</span>
                                </div>
                            </div>
                            <div class="metric-item">
                                <i class="fas fa-chart-line"></i>
                                <div class="metric-details">
                                    <span class="metric-value"><?= number_format($annonceStats['total_annonces'] / $userStats['total_users'], 1) ?></span>
                                    <span class="metric-label">Annonces/utilisateur</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Configuration des graphiques
const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
const annonceActivityCtx = document.getElementById('annonceActivityChart').getContext('2d');

// Graphique de croissance des utilisateurs
new Chart(userGrowthCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
        datasets: [{
            label: 'Nouveaux utilisateurs',
            data: [30, 45, 60, 75, 90, <?= $userStats['new_users_month'] ?>],
            borderColor: '#6b8e23',
            backgroundColor: 'rgba(107, 142, 35, 0.1)',
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        }
    }
});

// Graphique d'activité des annonces
new Chart(annonceActivityCtx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
        datasets: [{
            label: 'Annonces publiées',
            data: [45, 65, 85, 95, 110, <?= $annonceStats['new_annonces_month'] ?>],
            backgroundColor: 'rgba(107, 142, 35, 0.8)'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        }
    }
});
</script>

<?php require_once 'app/Views/includes/footer.php'; ?>