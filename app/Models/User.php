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

    public static function findById(int $id): ?array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM Personne WHERE personneId = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
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
        $stmt = $pdo->prepare("INSERT INTO Personne (nom, prenom, email, password, isAdmin, photoUrl) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute(['', '', $email, $hashedPassword, 0, null]);

        return (int)$pdo->lastInsertId();
    }
    public static function updateProfile(string $email, string $nom, string $prenom, ?string $photoUrl): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            UPDATE Personne
            SET nom = ?, prenom = ?, photoUrl = ?
            WHERE email = ?
        ");
        return $stmt->execute([$nom, $prenom, $photoUrl, $email]);
    }

    public static function edit(string $email, int $isAdmin, ?string $photoUrl): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            UPDATE Personne
            SET isAdmin = ?, photoUrl = ?
            WHERE email = ?
        ");
        return $stmt->execute([$isAdmin, $photoUrl, $email]);
    }

    public static function findAll(): array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query("SELECT * FROM Personne");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function delete(int $id): bool
    {
        $pdo = self::getPDO();
    
        try {
            $pdo->beginTransaction();
    
            $stmt = $pdo->prepare("SELECT conversationId FROM Conversation WHERE personne1Id = ? OR personne2Id = ?");
            $stmt->execute([$id, $id]);
            $conversationIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
            if ($conversationIds) {
                $in = implode(',', array_fill(0, count($conversationIds), '?'));
                $stmt = $pdo->prepare("DELETE FROM Message WHERE conversationId IN ($in)");
                $stmt->execute($conversationIds);
    
                $stmt = $pdo->prepare("DELETE FROM Conversation WHERE conversationId IN ($in)");
                $stmt->execute($conversationIds);
            }
    
            $stmt = $pdo->prepare("DELETE FROM Message WHERE senderId = ?");
            $stmt->execute([$id]);
    
            $stmt = $pdo->prepare("DELETE FROM AvisUtilisateur WHERE envoyeurId = ? OR receveurId = ?");
            $stmt->execute([$id, $id]);
    
            $stmt = $pdo->prepare("SELECT annonceId FROM Annonce WHERE personneId = ?");
            $stmt->execute([$id]);
            $annonces = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
            if ($annonces) {
                $in = implode(',', array_fill(0, count($annonces), '?'));
                $stmt = $pdo->prepare("DELETE FROM AvisUtilisateur WHERE annonceId IN ($in)");
                $stmt->execute($annonces);
            }
    
            $stmt = $pdo->prepare("DELETE FROM Annonce WHERE personneId = ?");
            $stmt->execute([$id]);
    
            $stmt = $pdo->prepare("DELETE FROM EspeceAnimal WHERE proprietaireId = ?");
            $stmt->execute([$id]);
    
            $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = (SELECT email FROM Personne WHERE personneId = ?)");
            $stmt->execute([$id]);
    
            $stmt = $pdo->prepare("DELETE FROM Personne WHERE personneId = ?");
            $stmt->execute([$id]);
    
            $pdo->commit();
            return true;
    
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }
    

    public function savePasswordResetToken(string $email, string $token, string $expires): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);

        $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)");
        return $stmt->execute([$email, $token, $expires]);
    }

    public function findByResetToken(string $token)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT email, expires FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword(string $email, string $hashedPassword): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("UPDATE Personne SET password = ? WHERE email = ?");
        return $stmt->execute([$hashedPassword, $email]);
    }

    public function deleteResetToken(string $token): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE token = ?");
        return $stmt->execute([$token]);
    }


}
