<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Foire Aux Questions</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
</head>
<body class="faq-page">
    <?php include(__DIR__ . '/../includes/header.php'); ?>

    <main>
        <section class="faq-section">
            <h2>Foire Aux Questions (FAQ)</h2>
            <div class="faq-item">
                <h3>Comment puis-je m'inscrire ?</h3>
                <p> Cliquez sur le bouton "S'inscrire" en haut à droite de la page et remplissez le formulaire. </p>
            </div>
            <div class="faq-item">
                <h3>Comment puis-je réinitialiser mon mot de passe ?</h3>
                <p> Cliquez sur "Mot de passe oublié" sur la page de connexion et suivez les instructions. </p>
            </div>
            <div class="faq-item">
                <h3>Comment nous contacter ?</h3>
                <p> Vous pouvez nous contacter en remplissant le formulaire sur notre <a href="/contact">page de contact</a>. Nous répondrons à votre demande dans les plus brefs délais. </p>
            </div>
        </section>

    </main>
    <script>
        document.querySelectorAll('.faq-item h3').forEach((header) => {
            header.addEventListener('click', () => {
            const item = header.parentElement;
            item.classList.toggle('active');
            });
        });
    </script>
    <?php include(__DIR__ . '/../includes/footer.php');?>
</body>
</html>