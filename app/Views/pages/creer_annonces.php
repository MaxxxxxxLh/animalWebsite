<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'AnimalWebsite - Créer une annonce') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6B8E23;
            --primary-light: #A2C257;
            --primary-dark: #556B2F;
            --secondary: #FF9800;
            --text: #333333;
            --text-light: #757575;
            --background: #FAF3E0;
            --card-bg: #ffffff;
            --border: #e0e0e0;
            --error: #f44336;
            --success: #6B8E23;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header inclus */
        header {
            background-color: var(--primary);
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Conteneur du formulaire */
        .form-container {
            background: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 30px auto;
            max-width: 900px;
        }

        .form-container h2 {
            color: var(--primary-dark);
            margin-bottom: 25px;
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-container h2 i {
            color: var(--primary);
        }

        /* Grille du formulaire */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text);
        }

        /* Styles des inputs */
        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
        }

        .input-icon input,
        .input-icon select,
        .input-icon textarea {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .input-icon input:focus,
        .input-icon select:focus,
        .input-icon textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }

        .input-icon textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* Style spécifique pour le prix */
        .price-input {
            position: relative;
        }

        .price-input span {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-weight: bold;
        }

        .price-input input {
            padding-left: 30px !important;
        }

        /* Upload de fichiers */
        .file-upload {
            border: 2px dashed var(--border);
            border-radius: 6px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .file-upload:hover {
            border-color: var(--primary);
        }

        .file-upload i {
            font-size: 40px;
            color: var(--primary);
            margin-bottom: 10px;
            display: block;
            position: relative;
            left: auto;
            transform: none;
        }

        .file-upload span {
            display: block;
            color: var(--text-light);
        }

        .file-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .preview-container {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        /* Bouton de soumission */
        button[type="submit"] {
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }

            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="container">
        <div class="form-container">
            <h2><i class="fas fa-plus-circle"></i> Créer une nouvelle annonce</h2>
            <form id="annonceForm" action="/cree-annonces/store" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="titre">Titre de l'annonce</label>
                        <div class="input-icon">
                            <i class="fas fa-heading"></i>
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
                            <input type="number" id="tarif" name="tarif" min="0" step="5" placeholder="Ex: 25">
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
                        <label for="personneId">Propriétaire</label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <select id="personneId" name="personneId" required>
                                <option value="">Sélectionnez un propriétaire</option>
                                <?php foreach ($proprietaires as $proprietaire): ?>
                                    <option value="<?= $proprietaire['id'] ?>">
                                        <?= htmlspecialchars($proprietaire['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
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

    <script>
        // Script pour l'aperçu des images
        document.getElementById('photos').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('previewContainer');
            previewContainer.innerHTML = '';
            
            if (this.files) {
                const files = Array.from(this.files).slice(0, 3); // Limite à 3 fichiers
                
                files.forEach(file => {
                    if (!file.type.match('image.*')) return;
                    
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '150px';
                        img.style.maxHeight = '150px';
                        img.style.borderRadius = '4px';
                        img.style.marginRight = '10px';
                        previewContainer.appendChild(img);
                    }
                    
                    reader.readAsDataURL(file);
                });
            }
        });

        // Validation du formulaire
        document.getElementById('annonceForm').addEventListener('submit', function(e) {
            const telephone = document.getElementById('telephone').value;
            if (!/^[0-9]{10}$/.test(telephone)) {
                alert('Veuillez entrer un numéro de téléphone valide (10 chiffres)');
                e.preventDefault();
            }
            
            // Autres validations si nécessaire
        });
    </script>
</body>
</html>