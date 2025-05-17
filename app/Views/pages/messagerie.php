<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie - Gardiennage d'Animaux</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .messagerie-page {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem 0;
        }

        .messagerie-page h1 {
            color: #6B8E23;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 2rem;
        }

        .messagerie-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }

        .messagerie-container {
            display: flex;
            width: 95%;
            max-width: 1400px;
            height: 75vh;
            min-height: 600px;
            max-height: 800px;
            background: #f8f9fa;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 0 auto;
        }

        /* Partie contacts - Redesign */
        .contacts-list {
            width: 350px;
            border-right: 1px solid #e0e0e0;
            background: #fff;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .contact-header {
            padding: 1.5rem;
            background: #6B8E23;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
        }

        .search-bar {
            padding: 1rem;
            background: #f5f5f5;
            border-bottom: 1px solid #e0e0e0;
        }

        .search-bar input {
            width: 100%;
            padding: 0.7rem 1.2rem;
            border: 1px solid #ddd;
            border-radius: 25px;
            outline: none;
            font-size: 0.9rem;
        }

        .contacts-scrollable {
            flex-grow: 1;
            overflow-y: auto;
        }

        .contact-item {
            padding: 1.2rem;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: all 0.2s;
        }

        .contact-item:hover {
            background: #f8f8f8;
        }

        .contact-item.active {
            background: #e8f5e9;
            border-left: 4px solid #6B8E23;
        }

        .contact-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #6B8E23;
            margin-right: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .contact-info {
            flex-grow: 1;
            min-width: 0;
        }

        .contact-name {
            font-weight: bold;
            margin-bottom: 0.3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1rem;
        }

        .contact-time {
            font-size: 0.75rem;
            color: #666;
            font-weight: normal;
        }

        .contact-preview {
            font-size: 0.85rem;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
        }

        .unread-badge {
            background: #6B8E23;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
        }

        /* Partie conversation - Recentrée */
        .chat-area {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background: #f5f5f5;
        }

        .chat-header {
            padding: 1.2rem 1.5rem;
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .chat-header-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #4F378A;
            margin-right: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .chat-header-info {
            flex-grow: 1;
        }

        .chat-header-name {
            font-weight: bold;
            margin-bottom: 0.1rem;
            font-size: 1.1rem;
        }

        .chat-header-status {
            font-size: 0.8rem;
            color: #666;
            display: flex;
            align-items: center;
        }

        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4CAF50;
            margin-right: 6px;
        }

        .chat-header-actions {
            display: flex;
            gap: 1.2rem;
        }

        .chat-header-actions button {
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 1.3rem;
            transition: color 0.2s;
        }

        .chat-header-actions button:hover {
            color: #6B8E23;
        }

        .messages-container {
            flex-grow: 1;
            padding: 1.5rem;
            overflow-y: auto;
            background: #f5f5f5;
            display: flex;
            flex-direction: column;
        }

        .message {
            margin-bottom: 1.2rem;
            max-width: 70%;
            padding: 1rem 1.2rem;
            border-radius: 15px;
            position: relative;
            line-height: 1.5;
            word-break: break-word;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message.received {
            background: white;
            align-self: flex-start;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border-top-left-radius: 5px;
        }

        .message.sent {
            background: #e3f2fd;
            align-self: flex-end;
            margin-left: auto;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border-top-right-radius: 5px;
        }

        .message-time {
            font-size: 0.75rem;
            color: #666;
            margin-top: 0.5rem;
            text-align: right;
        }

        .message-input-area {
            padding: 1.2rem;
            background: white;
            border-top: 1px solid #e0e0e0;
        }

        .message-input-container {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .message-input {
            flex-grow: 1;
            padding: 1rem 1.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 30px;
            outline: none;
            resize: none;
            min-height: 60px;
            max-height: 150px;
            line-height: 1.5;
            font-size: 0.95rem;
            transition: border 0.2s;
        }

        .message-input:focus {
            border-color: #6B8E23;
        }

        .send-button {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: #6B8E23;
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .send-button:hover {
            background: #5a7a1d;
            transform: scale(1.05);
        }

        .send-button i {
            font-size: 1.3rem;
        }

        /* Effets de scroll personnalisés */
        .contacts-scrollable::-webkit-scrollbar,
        .messages-container::-webkit-scrollbar {
            width: 6px;
        }

        .contacts-scrollable::-webkit-scrollbar-track,
        .messages-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .contacts-scrollable::-webkit-scrollbar-thumb,
        .messages-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .contacts-scrollable::-webkit-scrollbar-thumb:hover,
        .messages-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .messagerie-container {
                width: 98%;
                height: 80vh;
            }
            
            .contacts-list {
                width: 300px;
            }
        }

        @media (max-width: 768px) {
            .messagerie-page {
                padding: 1rem 0;
            }
            
            .messagerie-container {
                flex-direction: column;
                height: 85vh;
                min-height: 500px;
            }
            
            .contacts-list, .chat-area {
                width: 100%;
            }
            
            .contacts-list {
                height: 40%;
                border-right: none;
                border-bottom: 1px solid #e0e0e0;
            }
            
            .chat-area {
                height: 60%;
            }
        }
    </style>
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
</body>
</html>