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
    public static function findByEmail(string $email): ?array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM Personne WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function existsByEmail(string $email): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Personne WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }        

    public static function create(string $email, string $password): int
    {
        $pdo = self::getPDO();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO Personne (nom, prenom, email, password, isAdmin) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['', '', $email, $hashedPassword, 0]);

        return (int)$pdo->lastInsertId();
    }
}
