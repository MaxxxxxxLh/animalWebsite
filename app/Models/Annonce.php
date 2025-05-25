<?php
namespace App\Models;

use PDO;

class Annonce
{
    public static function getPDO()
    {
        global $pdo;
        return $pdo;
    }

    public static function findById(int $annonceId): ?array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM Annonce WHERE annonceId = ?");
        $stmt->execute([$annonceId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }   
    
    public static function findAll(): ?array
    {
        $pdo = self::getPDO();
        $sql = "
            SELECT 
                a.annonceId,
                a.nom AS nom_annonce,
                a.date,
                a.service,
                a.lieu,
                a.tarif,
                a.description,
                
                -- Infos du propriétaire
                p.nom AS nom_personne,
                p.prenom AS prenom_personne,
                p.email,
                p.photoUrl,

                -- Infos de l'animal
                ea.nom AS nom_animal,
                ea.age,
                ea.type,
                ea.informations

            FROM Annonce a
            JOIN Personne p ON a.personneId = p.personneId
            JOIN EspeceAnimal ea ON a.animalId = ea.animalId
        ";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public static function create(string $nom, string $date, string $service, string $lieu, int $tarif, string $description, int $personneId, int $animalId): int
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("INSERT INTO Annonce (nom, date, service, lieu, tarif, description, personneId, animalId) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $date, $service, $lieu, $tarif, $description, $personneId, $animalId]);
        return (int)$pdo->lastInsertId();
    }

    public static function search(?string $search = '', ?string $service = '', ?string $lieu = ''): array
    {
        $pdo = self::getPDO();
        $query = "SELECT * FROM Annonce WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $query .= " AND (nom LIKE :search OR description LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }

        if (!empty($service)) {
            $query .= " AND service = :service";
            $params['service'] = $service;
        }

        if (!empty($lieu)) {
            $query .= " AND lieu LIKE :lieu";
            $params['lieu'] = '%' . $lieu . '%';
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete(int $id): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("DELETE FROM Annonce WHERE annonceId = ?");
        return $stmt->execute([$id]);
    }

    public static function findByPersonneId($personneId)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            SELECT 
                a.*, 
                e.nom AS animalNom 
            FROM Annonce a
            JOIN EspeceAnimal e ON a.animalId = e.animalId
            WHERE a.personneId = ?
            ORDER BY a.date DESC
        ");
        $stmt->execute([$personneId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}