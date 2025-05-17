<?php

namespace App\Controllers\Api;

use App\Models\Message;

class MessageController
{
    public function findBypersonneId()
    {
        if (!isset($_GET['personneId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing personneId parameter']);
            return;
        }

        $personneId = (int)$_GET['personneId'];
        $messages = Message::findBypersonneId($personneId);

        header('Content-Type: application/json');
        echo json_encode($messages);
    }

    public function create()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['message'], $input['date'], $input['isProprietaireMessage'], $input['proprietaireId'], $input['personneId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            return;
        }

        $id = Message::create(
            $input['message'],
            $input['date'],
            (bool)$input['isProprietaireMessage'],
            (int)$input['proprietaireId'],
            (int)$input['personneId']
        );

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message_id' => $id]);
    }

    public function findAllConversations()
    {
        if (!isset($_GET['personneId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing personneId parameter']);
            return;
        }

        $personneId = (int)$_GET['personneId'];
        $conversations = Message::findAllConversations($personneId);

        header('Content-Type: application/json');
        echo json_encode($conversations);
    }


    public function findConversation()
    {
        if (!isset($_GET['personneId']) || !isset($_GET['proprietaireId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing personneId or proprietaireId parameter']);
            return;
        }

        $personneId = (int)$_GET['personneId'];
        $proprietaireId = (int)$_GET['proprietaireId'];

        $messages = Message::findConversation($personneId, $proprietaireId);

        header('Content-Type: application/json');
        echo json_encode($messages);
    }

}
