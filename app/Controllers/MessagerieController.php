<?php

namespace App\Controllers;

use App\Utils\APIClient;

class MessagerieController
{
    private function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . '/../Views/pages/' . $view . '.php';
    }

    public function showAllConversations()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user']['id'];
        $conversations = APIClient::get("http://localhost/api/message/conversations?personneId=$userId");

        $this->render('messagerie', [
            'conversations' => $conversations
        ]);
    }

    public function showConversation()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user']['id'];
        $autrePersonneId = $_GET['proprietaireId'] ?? null;

        if (!$autrePersonneId) {
            die("Aucun interlocuteur spécifié.");
        }

        // Obtenir ou créer une conversation
        $conversation = APIClient::get("http://localhost/api/message/getOrCreateConversation?personneId=$userId&proprietaireId=$autrePersonneId");

        if (!isset($conversation['id'])) {
            die("Erreur lors de la récupération ou création de la conversation.");
        }

        $conversationId = $conversation['id'];
        $messages = APIClient::get("http://localhost/api/message/conversation?conversationId=$conversationId");

        $this->render('conversation', [
            'messages' => $messages,
            'interlocuteurId' => $autrePersonneId,
            'conversationId' => $conversationId
        ]);
    }

    public function envoyerMessage()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: /");
            exit();
        }

        $userId = $_SESSION['user']['id'];
        $conversationId = $_POST['conversationId'] ?? null;
        $proprietaireId = $_POST['proprietaireId'] ?? null;
        $message = $_POST['message'] ?? '';

        if (empty($conversationId) || empty($proprietaireId) || empty($message)) {
            die("Tous les champs sont requis.");
        }

        $data = [
            'conversationId' => $conversationId,
            'personneId' => $userId,
            'proprietaireId' => $proprietaireId,
            'message' => $message,
            'date' => date('Y-m-d H:i:s'),
            'isProprietaireMessage' => false
        ];

        APIClient::post("http://localhost/api/message/create", $data);

        header("Location: /messagerie/findConversation?proprietaireId=$proprietaireId");
        exit();
    }
}
