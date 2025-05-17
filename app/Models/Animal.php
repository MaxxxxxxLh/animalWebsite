<?php
namespace App\Models;

use PDO;


class User
{
    public static function getPDO()
    {
        global $pdo;
        return $pdo;
    }
    public static function findByPersonneId(int $personneId): ?array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM Animal WHERE personneId = ?");
        $stmt->execute([$personneId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function existsByPersonneId(int $personneId): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Animal WHERE personneId = ?");
        $stmt->execute([$personneId]);
        return $stmt->fetchColumn() > 0;
    }        

    public static function create(string $nom, int $age, string $type, string $informations, int $personneId): int
    {
        $pdo = self::getPDO();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO Animal (nom, age, type, informations, personneId) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $age, $type, $informations, $personneId]);

        return (int)$pdo->lastInsertId();
    }
    public static function updateAnimal(string $nom, int $age, string $type, string $informations, int $personneId): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            UPDATE Animal
            SET nom = ?, age = ?, type = ?, informations = ?
            WHERE personneId = ?
        ");
        return $stmt->execute([$nom, $age, $type, $informations, $personneId]);
    }

}