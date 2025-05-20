<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie - Gardiennage d'Animaux</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/messagerie.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include(__DIR__ . '/../includes/header.php'); ?>

    <main class="messagerie-page">
        <h1>Vos messages</h1>
        
        <div class="messagerie-wrapper">
            <div class="messagerie-container">
                <div class="contacts-list">
                    <div class="contact-header">Conversations</div>
                    <div class="search-bar">
                        <input type="text" placeholder="Rechercher...">
                    </div>
                    <div class="contacts-scrollable">
                        <?php foreach ($conversations as $conv): ?>
                            <div class="contact-item <?= ($conv['id'] == $selectedUserId) ? 'active' : '' ?>"
                                onclick="window.location.href='?userId=<?= $conv['id'] ?>'">
                                <div class="contact-avatar">
                                    <?= strtoupper(substr($conv['nom'], 0, 1)) ?>
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">
                                        <?= htmlspecialchars($conv['nom']) ?>
                                        <?php if ($conv['nbMessagesNonLus'] > 0): ?>
                                            <span class="unread-badge"><?= $conv['nbMessagesNonLus'] ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="contact-preview">
                                        <?= htmlspecialchars($conv['dernierMessage']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="chat-area">
                    <div class="chat-header">
                        <div class="chat-header-avatar">
                            <?= strtoupper(substr($nomDestinataire ?? '...', 0, 1)) ?>
                        </div>
                        <div class="chat-header-info">
                            <div class="chat-header-name"><?= htmlspecialchars($nomDestinataire ?? 'Choisissez une conversation') ?></div>
                            <div class="chat-header-status">
                                <div class="status-indicator"></div> En ligne
                            </div>
                        </div>
                    </div>

                    <div class="messages-container">
                        <?php foreach ($messages as $msg): ?>
                            <div class="message <?= $msg['isProprietaireMessage'] ? 'received' : 'sent' ?>">
                                <div><?= htmlspecialchars($msg['message']) ?></div>
                                <div class="message-time"><?= htmlspecialchars($msg['date']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <form class="message-input-area" method="POST" action="/messages/send">
                        <div class="message-input-container">
                            <textarea class="message-input" name="message" placeholder="Écrivez un message..." required></textarea>
                            <input type="hidden" name="destinataire_id" value="<?= $selectedUserId ?? '' ?>">
                            <button type="submit" class="send-button"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include(__DIR__ . '/../includes/footer.php');?>
</body>
</html>