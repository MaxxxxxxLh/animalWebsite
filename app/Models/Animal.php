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
    public static function updateAnimal(string $nom, int $age, string $type, string $informations, int $animalId): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            UPDATE EspeceAnimal
            SET nom = ?, age = ?, type = ?, informations = ?
            WHERE animalId = ?
        ");
        return $stmt->execute([$nom, $age, $type, $informations, $animalId]);
    }

    public static function findByProprietaire($proprietaireId) {
        global $db;
        $stmt = $db->prepare("SELECT * FROM EspeceAnimal WHERE proprietaireId = ? ORDER BY animalId DESC");
        $stmt->execute([$proprietaireId]);
        return $stmt->fetchAll();
    }

    public static function findAll() {
        $pdo = self::getPDO();
        $stmt = $pdo->query("SELECT * FROM EspeceAnimal ORDER BY animalId DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($animalId) {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM EspeceAnimal WHERE animalId = ?");
        $stmt->execute([$animalId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateById($animalId, $nom, $age, $type, $informations) {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("UPDATE EspeceAnimal SET nom = ?, age = ?, type = ?, informations = ? WHERE animalId = ?");
        return $stmt->execute([$nom, $age, $type, $informations, $animalId]);
    }

    public static function deleteById($animalId) {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("DELETE FROM EspeceAnimal WHERE animalId = ?");
        return $stmt->execute([$animalId]);
    }
}