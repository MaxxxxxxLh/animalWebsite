<header>
    <nav class="navbar">
        <img src="/assets/images/logo.png" alt="Logo" class="logo">
        <div class="nav-links">
            <a href="/">Accueil</a>
            <a href="../pages/messagerie.php">Messagerie</a>
            <a href="../pages/annonces.php">Annonces</a>
            <a href="../pages/faq.php">FAQ</a>
            <a href="../pages/contact.php">Contact</a>
        </div>
        <div class="profile-icon">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="/logout">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' ... " alt="Profil"> 
            </a>
        <?php else: ?>
            <a href="/login">
                <button class="logoutBtn">Se connecter</button>
            </a>
        <?php endif; ?>
        </div>
    </nav>
</header>
