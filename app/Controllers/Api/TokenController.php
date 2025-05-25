<?php

namespace App\Api\Controllers;
use App\Utils\SecurityHelper;

class TokenController
{
    public function refreshToken(){
        header('Content-Type: application/json');
    
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Méthode non autorisée']);
            exit;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        $userId = $input['user_id'] ?? null;
        $refreshToken = $input['refresh_token'] ?? null;
        
        if (!$userId || !$refreshToken) {
            http_response_code(400);
            echo json_encode(['error' => 'Paramètres manquants']);
            exit;
        }
        
        if (!SecurityHelper::verifyRefreshToken((int)$userId, $refreshToken)) {
            http_response_code(401);
            echo json_encode(['error' => 'Refresh token invalide ou expiré']);
            exit;
        }
        
        $newAccessToken = SecurityHelper::generateAccessToken((int)$userId);
        $newRefreshToken = SecurityHelper::generateRefreshToken();
        SecurityHelper::storeRefreshToken((int)$userId, $newRefreshToken);
        
        echo json_encode([
            'access_token' => $newAccessToken,
            'refresh_token' => $newRefreshToken
        ]);
        exit;
        
    
    }
}