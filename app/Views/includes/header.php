

<header>
    <nav class="navbar">
        <img src="/assets/images/logo.png" alt="Logo" class="logo">
        <div class="nav-links">
            <a href="/">Accueil</a>
            <a href="/messagerie">Messagerie</a>
            <a href="/annonces">Annonces</a>
            <a href="/faq">FAQ</a>
        </div>

        <div class="profile-icon" id="profile-container">
            <?php if (isset($_SESSION['user'])): ?>
                <?php
                    $profilePic = isset($_SESSION['user']['photoUrl']) ? $_SESSION['user']['photoUrl'] : "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 58 61' width='58' height='61' fill='none'%3E%3Crect y='0.5' width='58' height='60' rx='29' fill='%236B8E23'/%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M37.7004 24.5C37.7004 29.4706 33.8052 33.5 29.0004 33.5C24.1955 33.5 20.3004 29.4706 20.3004 24.5C20.3004 19.5294 24.1955 15.5 29.0004 15.5C33.8052 15.5 37.7004 19.5294 37.7004 24.5ZM34.8004 24.5C34.8004 27.8137 32.2036 30.5 29.0004 30.5C25.7971 30.5 23.2004 27.8137 23.2004 24.5C23.2004 21.1863 25.7971 18.5 29.0004 18.5C32.2036 18.5 34.8004 21.1863 34.8004 24.5Z' fill='%234F378A'/%3E%3Cpath d='M29.0004 38C19.6125 38 11.6138 43.7426 8.56689 51.7881C9.30914 52.5505 10.091 53.2717 10.9091 53.9481C13.178 46.5615 20.2956 41 29.0004 41C37.7051 41 44.8227 46.5615 47.0916 53.9481C47.9097 53.2718 48.6916 52.5506 49.4338 51.7881C46.3869 43.7426 38.3882 38 29.0004 38Z' fill='%234F378A'/%3E%3C/svg%3E";
                ?>
                <img id="profile-toggle" src="<?= htmlspecialchars($profilePic) ?>" alt="Profil">

                <div id="dropdown-menu" class="dropdown-menu hidden">
                    <a href="/profile">Profil</a>
                    <a href="/logout">Se déconnecter</a>
                </div>
            <?php else: ?>
                <a href="/login">
                    <button class="logoutBtn">Se connecter</button>
                </a>
            <?php endif; ?>
        </div>
    </nav>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const toggle = document.getElementById("profile-toggle");
            const menu = document.getElementById("dropdown-menu");

            document.addEventListener("click", function (e) {
                const container = document.getElementById("profile-container");
                if (container.contains(e.target)) {
                    if (e.target === toggle) {
                        menu.classList.toggle("hidden");
                    }
                } else {
                    menu.classList.add("hidden");
                }
            });
        });
    </script>
</header>
