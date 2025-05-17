<?php

namespace App\Controllers;

class MessagerieController
{
    private function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . '/../Views/pages/' . $view . '.php';
    }

    private function apiGet(string $url): array
    {
        $response = @file_get_contents($url);

        if ($response === false) {
            return ['error' => 'API request failed'];
        }

        $data = json_decode($response, true);
        return is_array($data) ? $data : ['error' => 'Invalid JSON'];
    }

    private function apiPost(string $url, array $data): array
    {
        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];
        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            return ['error' => 'API POST request failed'];
        }

        $data = json_decode($response, true);
        return is_array($data) ? $data : ['error' => 'Invalid JSON'];
    }

    public function showAllConversations()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user']['id'];

        $conversations = $this->apiGet("http://localhost/api/message/findAllConversations?personneId=$userId");

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

        $messages = $this->apiGet("http://localhost/api/message/findConversation?personneId=$userId&proprietaireId=$proprietaireId");

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
        

        $this->apiPost("http://localhost/api/message/create", $data);

        header("Location: /messagerie/findConversation?proprietaireId=$proprietaireId");
        exit();
    }
}
