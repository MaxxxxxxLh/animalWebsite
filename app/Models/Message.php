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

    public static function findByConversationId(int $conversationId): array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            SELECT * FROM Message
            WHERE conversationId = :conversationId
            ORDER BY sentAt ASC
        ");
        $stmt->execute(['conversationId' => $conversationId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(string $content, int $conversationId, int $senderId): int
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            INSERT INTO Message (content, conversationId, senderId)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$content, $conversationId, $senderId]);
        return (int)$pdo->lastInsertId();
    }

    public static function findConversationBetween(int $user1, int $user2): ?array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            SELECT * FROM Conversation
            WHERE (personne1Id = :user1 AND personne2Id = :user2)
               OR (personne1Id = :user2 AND personne2Id = :user1)
            LIMIT 1
        ");
        $stmt->execute(['user1' => $user1, 'user2' => $user2]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public static function createConversation(int $user1, int $user2): int
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            INSERT INTO Conversation (personne1Id, personne2Id)
            VALUES (?, ?)
        ");
        $stmt->execute([$user1, $user2]);
        return (int)$pdo->lastInsertId();
    }

    public static function findAllConversations(int $userId): array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            SELECT 
                c.conversationId,
                CASE
                    WHEN c.personne1Id = :userId THEN c.personne2Id
                    ELSE c.personne1Id
                END AS interlocuteurId,
                p.nom AS interlocuteurNom,
                p.prenom AS interlocuteurPrenom,
                m.content AS dernierMessage,
                m.sentAt AS dateDernierMessage
            FROM Conversation c
            LEFT JOIN (
                SELECT m1.*
                FROM Message m1
                INNER JOIN (
                    SELECT conversationId, MAX(sentAt) AS latest
                    FROM Message
                    GROUP BY conversationId
                ) m2 ON m1.conversationId = m2.conversationId AND m1.sentAt = m2.latest
            ) m ON m.conversationId = c.conversationId
            JOIN Personne p ON p.personneId = (
                CASE
                    WHEN c.personne1Id = :userId THEN c.personne2Id
                    ELSE c.personne1Id
                END
            )
            WHERE c.personne1Id = :userId OR c.personne2Id = :userId
            ORDER BY m.sentAt DESC
        ");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public static function sendMessage(int $senderId, int $receiverId, string $content): array
    {
        $pdo = self::getPDO();

        $conversation = self::findConversationBetween($senderId, $receiverId);

        if (!$conversation) {
            $conversationId = self::createConversation($senderId, $receiverId);
        } else {
            $conversationId = $conversation['conversationId'];
        }

        $messageId = self::create($content, $conversationId, $senderId);

        return [
            'message_id' => $messageId,
            'conversation_id' => $conversationId,
        ];
    }

}
