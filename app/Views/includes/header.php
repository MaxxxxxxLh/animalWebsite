<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'AnimalWebsite') ?></title>
    <link rel="stylesheet" href="../../../public/assets/css/components/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php if (isset($page_css)): ?>
        <link rel="stylesheet" href="../../../public/assets/css/components/<?= $page_css ?>.css">
    <?php endif; ?>
</head>
<body>
<header>
    <nav class="navbar">
        <a href="/" class="logo-link">
            <img src="/assets/images/logo.png" alt="Logo AnimalWebsite" class="logo" width="120" height="60">
        </a>
        
        <div class="nav-links">
            <a href="/" class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">Accueil</a>
            
            <a href="/annonces" class="<?= basename($_SERVER['PHP_SELF']) === 'annonces.php' ? 'active' : '' ?>">Annonces</a>
            <a href="/messagerie" class="<?= basename($_SERVER['PHP_SELF']) === 'messagerie.php' ? 'active' : '' ?>">Messagerie</a>
            <a href="/faq" class="<?= basename($_SERVER['PHP_SELF']) === 'faq.php' ? 'active' : '' ?>">FAQ</a>
            <a href="/contact" class="<?= basename($_SERVER['PHP_SELF']) === 'contact.php' ? 'active' : '' ?>">Contact</a>
        </div>
        
        <div class="profile-icon">
            <?php if (isset($_SESSION['user'])): ?>
                <div class="dropdown">
                    <button class="dropdown-toggle">
                        <img src="<?= htmlspecialchars($_SESSION['user']['avatar'] ?? '/assets/images/default-avatar.png') ?>" 
                             alt="Photo de profil" 
                             class="profile-avatar"
                             width="40" 
                             height="40">
                    </button>
                    <div class="dropdown-menu">
                        <a href="/profil">Mon profil</a>
                        <a href="/mes-annonces">Mes annonces</a>
                        <a href="/logout">Déconnexion</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="/login" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </a>
            <?php endif; ?>
        </div>
    </nav>
</header>