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
        $stmt = $pdo->query("SELECT * FROM Annonce");
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

}