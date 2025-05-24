<?php
$selectedUserId = $_GET['userId'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie - Gardiennage d'Animaux</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/pages/messagerie.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        const CURRENT_USER_ID = <?= json_encode($_SESSION['user']['id']) ?>;
    </script>
</head>
<body>
    <?php include(__DIR__ . '/../includes/header.php'); ?>

    <main class="messagerie-page">
        <h1>Vos messages</h1>

        <section class="nouveau-message-form">
            <h2>Envoyer un nouveau message</h2>
            <form id="form-nouveau-message" class="form-nouveau-message">
                <select id="userSelect" required>
                    <option value="">Choisissez un destinataire</option>
                </select>
                <input type="text" name="message" id="messageInput" placeholder="Votre message..." required>
                <button type="submit"><i class="fas fa-paper-plane"></i> Envoyer</button>
            </form>
        </section>

        <div class="messagerie-wrapper">
            <div class="messagerie-container">
                <div class="contacts-list">
                    <div class="contact-header">Conversations</div>
                    <div class="search-bar">
                        <input type="text" placeholder="Rechercher...">
                    </div>
                    <div class="contacts-scrollable" id="conversationsList"></div> 
                </div>

                <div class="chat-area">
                    <div class="chat-header">
                        <div class="chat-header-avatar">
                            <?= strtoupper(substr($nomDestinataire ?? '...', 0, 1)) ?>
                        </div>
                        <div class="chat-header-info">
                            <div class="chat-header-name"><?= htmlspecialchars($nomDestinataire ?? 'Choisissez une conversation') ?></div>
                            <div class="chat-header-status"><div class="status-indicator"></div> En ligne</div>
                        </div>
                    </div>

                    <div class="messages-container" id="messagesContainer"></div>

                    <form class="message-input-area">
                        <div class="message-input-container">
                            <textarea class="message-input" name="message" placeholder="Écrivez un message..." required></textarea>
                            <input type="hidden" name="proprietaireId" id="proprietaireIdHidden" value="<?= $selectedUserId ?? '' ?>">
                            <button type="submit" class="send-button"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>

    <?php include(__DIR__ . '/../includes/footer.php'); ?>
    <script src="/js/secureFetch.js"></script>
    <script src="/js/messagerie.js"></script> 
</body>
</html>
