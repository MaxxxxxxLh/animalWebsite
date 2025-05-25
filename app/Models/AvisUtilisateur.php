<?php

namespace App\Models;

use PDO;

class AvisUtilisateur
{
    public static function getPDO()
    {
        global $pdo;
        return $pdo;
    }

    public static function create(int $annonceId,int $envoyeurId, int $receveurId, int $notes, string $commentaire): int
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            INSERT INTO AvisUtilisateur (annonceId, envoyeurId, receveurId, notes, commentaire)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$annonceId, $envoyeurId, $receveurId, $notes, $commentaire]);
        return (int)$pdo->lastInsertId();
    }

    public static function findByUserId(int $userId): array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            SELECT au.*, a.nom AS auteurNom, a.prenom AS auteurPrenom
            FROM AvisUtilisateur au
            JOIN Personne a ON a.personneId = au.auteurId
            WHERE au.receveurId = :userId
            ORDER BY au.date DESC
        ");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findAverageNoteForUser(int $userId): float
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            SELECT AVG(note) AS moyenne
            FROM AvisUtilisateur
            WHERE receveurId = :userId
        ");
        $stmt->execute(['userId' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['moyenne'] !== null ? (float)$result['moyenne'] : 0.0;
    }
}
