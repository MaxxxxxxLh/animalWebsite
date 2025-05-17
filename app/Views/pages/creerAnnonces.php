<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'AnimalWebsite') ?></title>
    <link rel="stylesheet" href="../assets/css/pages/creer_annonces.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/pages/creerAnnonces.css">

</head>
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container">
        <div class="form-container">
            <h2><i class="fas fa-plus-circle"></i> Créer une nouvelle annonce</h2>
            <form id="annonceForm" action="/annonces/create" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="titre">Titre de l'annonce</label>
                        <div class="input-icon">
                            <i class="fas fa-font"></i>
                            <input type="text" id="titre" name="titre" placeholder="Ex: Garde de chien à domicile" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="date">Date de service</label>
                        <div class="input-icon">
                            <i class="far fa-calendar-alt"></i>
                            <input type="date" id="date" name="date" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="service">Type de service</label>
                        <div class="input-icon">
                            <i class="fas fa-paw"></i>
                            <select id="service" name="service" required>
                                <option value="">Sélectionnez un service</option>
                                <option value="garde">Garde d'animal</option>
                                <option value="promenade">Promenade</option>
                                <option value="nourrissage">Nourrissage</option>
                                <option value="autre">Autre service</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="tarif">Tarif (€)</label>
                        <div class="price-input">
                            <span>€</span>
                            <input type="number" id="tarif" name="tarif" min="0" step="1" placeholder="Ex: 25">
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="description">Description détaillée</label>
                        <div class="input-icon">
                            <i class="fas fa-align-left"></i>
                            <textarea id="description" name="description" placeholder="Décrivez en détail votre annonce..." required></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="lieu">Ville/Quartier</label>
                        <div class="input-icon">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" id="lieu" name="lieu" placeholder="Ex: Paris 15ème" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="animalId">Animal concerné</label>
                        <div class="input-icon">
                            <i class="fas fa-dog"></i>
                            <select id="animalId" name="animalId" required>
                                <option value="">Sélectionnez un animal</option>
                                <?php foreach ($animaux as $animal): ?>
                                    <option value="<?= $animal['id'] ?>">
                                        <?= htmlspecialchars($animal['nom']) ?> (<?= htmlspecialchars($animal['type']) ?> - <?= htmlspecialchars($animal['race']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="telephone">Contact téléphonique</label>
                        <div class="input-icon">
                            <i class="fas fa-phone"></i>
                            <input type="tel" id="telephone" name="telephone" 
                                   placeholder="Ex: 06 12 34 56 78" 
                                   pattern="[0-9]{10}" 
                                   title="Entrez un numéro français valide (10 chiffres)" 
                                   required>
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label>Photos de l'animal (max 3)</label>
                        <div class="file-upload" id="fileUpload">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Glissez-déposez vos photos ou cliquez pour parcourir</span>
                            <input type="file" id="photos" name="photos[]" accept="image/*" multiple>
                        </div>
                        <div class="preview-container" id="previewContainer"></div>
                    </div>
                </div>
                
                <button type="submit"><i class="fas fa-paper-plane"></i> Publier l'annonce</button>
            </form>
        </div>
    </main>


<?php include __DIR__ . '/../includes/footer.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="../assets/js/createAnnonce.js"></script>