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

        $conversations = APIClient::get("http://localhost/api/message/findAllConversations?personneId=$userId");

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
        $proprietaireId = $_GET['proprietaireId'] ?? null;

        if (!$proprietaireId) {
            die("Aucun interlocuteur spécifié.");
        }

        $messages = APIClient::get("http://localhost/api/message/findConversation?personneId=$userId&proprietaireId=$proprietaireId");

        $this->render('conversation', [
            'messages' => $messages,
            'interlocuteurId' => $proprietaireId
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
        $proprietaireId = $_POST['proprietaireId'] ?? null;
        $message = $_POST['message'] ?? '';

        if (empty($proprietaireId) || empty($message)) {
            die("Tous les champs sont requis.");
        }

        $data = [
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
