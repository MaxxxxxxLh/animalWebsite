<?php

class CreeAnnoncesController
{
    public function showForm()
    {
        // Récupération des données nécessaires
        $proprietaires = $this->getProprietaires();
        $animaux = $this->getAnimaux();
        
        // Inclusion de la vue
        require __DIR__ . '/../../Views/pages/cree-annonces.php';
    }
    
    public function processForm()
    {
        // Validation des données
        $this->validateRequest();
        
        // Traitement du formulaire
        $annonceId = $this->saveAnnonce();
        
        // Gestion des uploads
        $this->handleUploads($annonceId);
        
        // Redirection
        header('Location: /annonces?success=1');
        exit();
    }
    
    private function getProprietaires()
    {
        // À remplacer par un appel à votre modèle
        return [
            ['id' => 1, 'nom' => 'Jean Dupont'],
            ['id' => 2, 'nom' => 'Marie Martin']
        ];
    }
    
    private function getAnimaux()
    {
        // À remplacer par un appel à votre modèle
        return [
            ['id' => 1, 'nom' => 'Rex', 'type' => 'Chien'],
            ['id' => 2, 'nom' => 'Misty', 'type' => 'Chat']
        ];
    }
    
    private function validateRequest()
    {
        $required = ['titre', 'date', 'service', 'description', 'lieu'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Le champ $field est requis");
            }
        }
    }
    
    private function saveAnnonce()
    {
        // Logique de sauvegarde en base
        // Retourne l'ID de l'annonce créée
        return 1; // Exemple
    }
    
    private function handleUploads($annonceId)
    {
        if (!empty($_FILES['photos'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/annonces/' . $annonceId . '/';
            
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                    $filename = uniqid() . '_' . basename($_FILES['photos']['name'][$key]);
                    move_uploaded_file($tmpName, $uploadDir . $filename);
                }
            }
        }
    }
}