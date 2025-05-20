<?php
namespace App\Models;

use PDO;


class Animal
{
    public static function getPDO()
    {
        global $pdo;
        return $pdo;
    }
    public static function findByProprietaireId(int $proprietaireId): ?array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM EspeceAnimal WHERE proprietaireId = ?");
        $stmt->execute([$proprietaireId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public static function existsByProprietaireId(int $proprietaireId): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM EspeceAnimal WHERE proprietaireId = ?");
        $stmt->execute([$proprietaireId]);
        return $stmt->fetchColumn() > 0;
    }        

    public static function create(string $nom, int $age, string $type, string $informations, int $proprietaireId): int
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("INSERT INTO EspeceAnimal (nom, age, type, informations, proprietaireId) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $age, $type, $informations, $proprietaireId]);

        return (int)$pdo->lastInsertId();
    }
    public static function updateAnimal(string $nom, int $age, string $type, string $informations, int $proprietaireId): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            UPDATE EspeceAnimal
            SET nom = ?, age = ?, type = ?, informations = ?
            WHERE proprietaireId = ?
        ");
        return $stmt->execute([$nom, $age, $type, $informations, $proprietaireId]);
    }

}