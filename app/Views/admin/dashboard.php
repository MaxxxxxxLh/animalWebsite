<?php include_once 'app/Views/includes/header.php'; ?>

<div class="admin-dashboard">
    <div class="admin-sidebar">
        <div class="admin-logo">
            <i class="fas fa-paw"></i>
            <span>Admin Panel</span>
        </div>
        <nav class="admin-nav">
            <a href="/admin/dashboard" class="active">
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
            <a href="/admin/analytics">
                <i class="fas fa-chart-bar"></i>
                Statistiques
            </a>
        </nav>
    </div>

    <div class="admin-main">
        <header class="admin-header">
            <h1>Tableau de bord</h1>
            <div class="admin-profile">
                <span>Bienvenue, <?= htmlspecialchars($_SESSION['user']['email']) ?></span>
                <a href="/logout" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </header>

        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>Utilisateurs</h3>
                    <p><?= $totalUsers ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="stat-info">
                    <h3>Annonces</h3>
                    <p><?= $totalAnnonces ?></p>
                </div>
            </div>
        </div>

        <div class="dashboard-recent">
            <div class="recent-section">
                <h2>Dernières annonces</h2>
                <div class="recent-grid">
                    <?php foreach ($recentAnnonces as $annonce): ?>
                        <div class="recent-card">
                            <h4><?= htmlspecialchars($annonce['title']) ?></h4>
                            <p><?= htmlspecialchars(substr($annonce['description'], 0, 100)) ?>...</p>
                            <span class="date"><?= date('d/m/Y', strtotime($annonce['created_at'])) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="recent-section">
                <h2>Nouveaux utilisateurs</h2>
                <div class="recent-grid">
                    <?php foreach ($newUsers as $user): ?>
                        <div class="recent-card">
                            <h4><?= htmlspecialchars($user['email']) ?></h4>
                            <p>Role: <?= htmlspecialchars($user['role']) ?></p>
                            <span class="date"><?= date('d/m/Y', strtotime($user['created_at'])) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="dashboard-chart">
            <h2>Évolution des annonces</h2>
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('monthlyChart').getContext('2d');
const monthlyData = <?= json_encode($monthlyStats) ?>;

new Chart(ctx, {
    type: 'line',
    data: {
        labels: monthlyData.map(item => {
            const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
            return months[item.month - 1];
        }),
        datasets: [{
            label: 'Nombre d\'annonces',
            data: monthlyData.map(item => item.count),
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
</script>

<?php include_once 'app/Views/includes/footer.php'; ?>