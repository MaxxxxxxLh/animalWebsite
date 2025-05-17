<?php

namespace App\Models;

use PDO;

class Message
{
    public static function getPDO()
    {
        global $pdo;
        return $pdo;
    }

    public static function findByUserId(int $userId): array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM Messagerie WHERE personneId = :userId OR proprietaireId = :userId ORDER BY date ASC");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(string $message, string $date, bool $isProprietaireMessage, int $proprietaireId, int $personneId): int
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("INSERT INTO Messagerie (message, date, isProprietaireMessage, proprietaireId, personneId) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$message, $date, $isProprietaireMessage, $proprietaireId, $personneId]);
        return (int)$pdo->lastInsertId();
    }
    
    public static function findAllConversations(int $userId): array
    {
        $pdo = self::getPDO();

        $stmt = $pdo->prepare("
            SELECT 
                CASE 
                    WHEN personneId = :userId THEN proprietaireId
                    ELSE personneId
                END AS interlocuteurId,
                MAX(date) AS dateDernierMessage,
                (
                    SELECT message FROM Messagerie m2 
                    WHERE 
                        (m2.personneId = :userId AND m2.proprietaireId = interlocuteurId)
                        OR 
                        (m2.personneId = interlocuteurId AND m2.proprietaireId = :userId)
                    ORDER BY m2.date DESC
                    LIMIT 1
                ) AS dernierMessage
            FROM Messagerie
            WHERE personneId = :userId OR proprietaireId = :userId
            GROUP BY interlocuteurId
            ORDER BY dateDernierMessage DESC
        ");

        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function findConversation(int $personneId, int $proprietaireId): array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            SELECT * FROM Messagerie
            WHERE 
                (personneId = :personneId AND proprietaireId = :proprietaireId)
                OR 
                (personneId = :proprietaireId AND proprietaireId = :personneId)
            ORDER BY date ASC
        ");
        $stmt->execute([
            'personneId' => $personneId,
            'proprietaireId' => $proprietaireId
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
