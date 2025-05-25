<?php
$userId = $_SESSION['user']['id'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Annonces - Gardiennage d'animaux</title>
    <link rel="stylesheet" href="/css/pages/annonces.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="container">
        <section class="search-section">
            <h2>Rechercher une annonce</h2>
            <form class="search-form" method="GET" action="/annonce/search">
                <div class="search-grid">
                    <div class="search-group">
                        <label for="search">Recherche</label>
                        <div class="input-icon">
                            <i class="fas fa-search"></i>
                            <input type="text" id="search" name="search" 
                                   placeholder="Rechercher une annonce..."
                                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="search-group">
                        <label for="service">Type de service</label>
                        <div class="input-icon">
                            <i class="fas fa-concierge-bell"></i>
                            <select id="service" name="service">
                                <option value="">Tous les services</option>
                                <option value="garde" <?= ($_GET['service'] ?? '') === 'garde' ? 'selected' : '' ?>>Garde d'animal</option>
                                <option value="promenade" <?= ($_GET['service'] ?? '') === 'promenade' ? 'selected' : '' ?>>Promenade</option>
                                <option value="nourrissage" <?= ($_GET['service'] ?? '') === 'nourrissage' ? 'selected' : '' ?>>Nourrissage</option>
                                <option value="autre" <?= ($_GET['service'] ?? '') === 'autre' ? 'selected' : '' ?>>Autre service</option>
                            </select>
                        </div>
                    </div>

                    <div class="search-group">
                        <label for="lieu">Lieu</label>
                        <div class="input-icon">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" id="lieu" name="lieu" 
                                   placeholder="Ville ou région..."
                                   value="<?= htmlspecialchars($_GET['lieu'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="search-group search-button">
                        <button type="submit">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <section class="annonces-section">
            <h2>Liste des annonces</h2>
            
            <div class="annonces-grid">
                <?php if (empty($annonces)): ?>
                    <div class="no-results">
                        <i class="fas fa-info-circle"></i>
                        <p>Aucune annonce ne correspond à votre recherche.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script>
        userId = <?= json_encode($userId) ?>;
    </script>
    <script src="/js/annonce.js"></script>
    <script src="/js/secureFetch.js"></script>
    <script src="/js/openConversation.js"></script>
</body>
</html> 