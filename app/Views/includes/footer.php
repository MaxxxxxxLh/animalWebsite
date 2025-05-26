<footer class="main-footer">
    <div class="footer-container">
        <div class="footer-section">
            <h2 class="footer-title">À propos</h2>
            <div class="footer-links">
                <img src="/assets/images/logo.png" alt="Logo">
                <p>Votre plateforme de confiance pour le gardiennage d'animaux. Trouvez la personne idéale pour prendre soin de vos compagnons.</p>
            </div>
        </div>
        
        <div class="footer-section">
            <h3 class="footer-title">Liens rapides</h3>
            <div class="footer-links">
                <a href="/"><i class="fas fa-home"></i> Accueil</a>
                <a href="/annonces"><i class="fas fa-paw"></i> Toutes les annonces</a>
                <a href="/devenir-gardien"><i class="fas fa-user-plus"></i> Devenir gardien</a>
                <a href="/faq"><i class="fas fa-question-circle"></i> FAQ</a>
                <a href="/contact"><i class="fas fa-envelope"></i> Contact</a>
            </div>
        </div>
        
        <div class="footer-section">
            <h3 class="footer-title">Informations</h3>
            <div class="footer-links">
                <a href="/qui-sommes-nous"><i class="fas fa-info-circle"></i> Qui sommes-nous</a>
                <a href="/mentions-legales"><i class="fas fa-gavel"></i> Mentions légales</a>
                <a href="/cgu"><i class="fas fa-file-contract"></i> CGU</a>
                <a href="/politique-confidentialite"><i class="fas fa-shield-alt"></i> Politique de confidentialité</a>
            </div>
        </div>
        
        <div class="footer-section">
            <h3 class="footer-title">Newsletter</h3>
            <p>Ne manquez aucune information utile sur le bien-être animal, les nouveautés du site et nos recommandations pour mieux vivre avec vos animaux.</p>
            <div class="footer-newsletter">
                <form id="newsletter-form">
                    <input type="email" placeholder="Votre adresse email" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i> S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> - Gardiennage d'animaux - Tous droits réservés - Non conforme</p>
    </div>
</footer>

<!-- Script pour l'animation du footer -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des éléments du footer
    const footerElements = document.querySelectorAll('.footer-section');
    footerElements.forEach((element, index) => {
        setTimeout(() => {
            element.classList.add('fadeIn');
        }, 100 * index);
    });
    
    // Script pour le formulaire newsletter
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            
            // Simuler l'envoi (à remplacer par votre logique d'envoi)
            alert('Merci de vous être inscrit avec l\'adresse: ' + email);
            this.reset();
        });
    }
});
</script>