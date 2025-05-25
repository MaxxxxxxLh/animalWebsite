<?php

namespace App\Controllers\Api;

use App\Models\Message;

class MessageController
{
    public function findByConversationId()
    {
        if (!isset($_GET['conversationId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing conversationId parameter']);
            return;
        }

        $conversationId = (int)$_GET['conversationId'];
        $messages = Message::findByConversationId($conversationId);

        header('Content-Type: application/json');
        echo json_encode($messages);
    }

    public function create()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['content'], $input['senderId'], $input['receiverId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            return;
        }

        $result = Message::sendMessage(
            (int)$input['senderId'],
            (int)$input['receiverId'],
            $input['content']
        );

        if (!$result || !isset($result['message_id'], $result['conversation_id'])) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to send message']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message_id' => $result['message_id'],
            'conversationId' => $result['conversation_id']
        ]);
    }


    public function findAllConversations()
    {
        if (!isset($_GET['userId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing userId parameter']);
            return;
        }

        $userId = (int)$_GET['userId'];
        $conversations = Message::findAllConversations($userId);

        header('Content-Type: application/json');
        echo json_encode($conversations);
    }

    public function findConversationBetween()
    {
        if (!isset($_GET['user1']) || !isset($_GET['user2'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing user1 or user2 parameter']);
            return;
        }

        $user1 = (int)$_GET['user1'];
        $user2 = (int)$_GET['user2'];

        $conversation = Message::findConversationBetween($user1, $user2);

        if ($conversation) {
            header('Content-Type: application/json');
            echo json_encode($conversation);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Conversation not found']);
        }
    }
}
