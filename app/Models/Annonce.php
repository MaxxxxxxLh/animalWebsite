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

    public static function create(int $annonceId, string $nom, string $date, string $service, string $lieu, int $personneId, int $animalId): int
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("INSERT INTO Annonce (annonceId, nom, date, service, lieu, personneId, animalId) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$annonceId, $nom, $date, $service, $lieu, $personneId, $animalId]);
        return (int)$pdo->lastInsertId();
    }
}