<?php 
$pageTitle = 'Qui sommes-nous ?';
?>
<!DOCTYPE html>
<ht lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cgu - Gardiennage d'animaux</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/pages/qui-sommes-nous.css">
</head>
<body>
<?php include(__DIR__ . '/../includes/header.php'); ?>
<main class="container">
    <div class="page-header">
        <h1><i class="fas fa-heart"></i> Qui sommes-nous ?</h1>
        <p class="page-subtitle">Passionnés par le bien-être animal depuis toujours</p>
    </div>

    <section class="content-section">
        <div class="about-content">
            <!-- Section Hero -->
            <div class="hero-section">
                <div class="hero-text">
                    <h2><i class="fas fa-paw"></i> Notre passion, votre tranquillité</h2>
                    <p>
                        Notre plateforme met en relation des propriétaires d'animaux et des gardiens de confiance 
                        partout en France. Passionnés par le bien-être animal, nous avons créé ce service pour 
                        faciliter la garde, la promenade et le soin de vos compagnons à quatre pattes.
                    </p>
                </div>
                <div class="hero-image">
                    <i class="fas fa-users-cog hero-icon"></i>
                </div>
            </div>

            <!-- Notre Mission -->
            <div class="mission-section">
                <h2><i class="fas fa-bullseye"></i> Notre mission</h2>
                <div class="mission-grid">
                    <div class="mission-item">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Service sécurisé</h3>
                        <p>Offrir un service sécurisé et fiable pour le gardiennage d'animaux avec des gardiens vérifiés.</p>
                    </div>
                    <div class="mission-item">
                        <i class="fas fa-star"></i>
                        <h3>Excellence reconnue</h3>
                        <p>Mettre en avant la passion et l'expérience de nos gardiens pour un service d'exception.</p>
                    </div>
                    <div class="mission-item">
                        <i class="fas fa-smile"></i>
                        <h3>Tranquillité d'esprit</h3>
                        <p>Garantir la tranquillité d'esprit des propriétaires lors de leurs absences.</p>
                    </div>
                </div>
            </div>

            <!-- Nos Valeurs -->
            <div class="values-section">
                <h2><i class="fas fa-gem"></i> Nos valeurs</h2>
                <div class="values-container">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Passion</h3>
                        <p>L'amour des animaux est au cœur de tout ce que nous faisons. Chaque membre de notre équipe partage cette passion.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3>Confiance</h3>
                        <p>Nous créons des liens de confiance durables entre propriétaires et gardiens grâce à notre système de vérification.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Communauté</h3>
                        <p>Nous rassemblons une communauté bienveillante d'amoureux des animaux partageant les mêmes valeurs.</p>
                    </div>
                </div>
            </div>

            <!-- Pourquoi nous choisir -->
            <div class="why-choose-section">
                <h2><i class="fas fa-question-circle"></i> Pourquoi nous choisir ?</h2>
                <div class="advantages-list">
                    <div class="advantage-item">
                        <div class="advantage-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="advantage-content">
                            <h3>Profils vérifiés</h3>
                            <p>Tous nos gardiens sont vérifiés et leurs profils sont validés. Consultez les avis et évaluations laissés par d'autres propriétaires.</p>
                        </div>
                    </div>
                    
                    <div class="advantage-item">
                        <div class="advantage-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="advantage-content">
                            <h3>Support réactif</h3>
                            <p>Notre équipe d'assistance est disponible pour vous accompagner et répondre à toutes vos questions rapidement.</p>
                        </div>
                    </div>
                    
                    <div class="advantage-item">
                        <div class="advantage-icon">
                            <i class="fas fa-list-ul"></i>
                        </div>
                        <div class="advantage-content">
                            <h3>Services variés</h3>
                            <p>Large choix de services adaptés à vos besoins : garde à domicile, promenades, visites, pension, et bien plus encore.</p>
                        </div>
                    </div>
                    
                    <div class="advantage-item">
                        <div class="advantage-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="advantage-content">
                            <h3>Proximité géographique</h3>
                            <p>Trouvez facilement des gardiens près de chez vous grâce à notre système de géolocalisation précis.</p>
                        </div>
                    <h2><i class="fas fa-rocket"></i> Rejoignez notre communauté !</h2>
                    <p>Des milliers de propriétaires nous font déjà confiance. Inscrivez-vous dès aujourd'hui pour trouver le gardien idéal pour votre animal.</p>
                    <a href="/register" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> S'inscrire
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>

