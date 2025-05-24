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
    <script src="/js/secureFetch.js"></script>
</head>
<script>

    async function populateUserSelect() {
        try {
            const users = await secureFetch('/api/users/findAll');
            const currentUserId = <?= json_encode($_SESSION['user']['id']) ?>;
            const select = document.getElementById('userSelect');

            users
                .filter(user => user.personneId != currentUserId)
                .forEach(user => {
                    console.log(user);
                    const option = document.createElement('option');
                    option.value = user.personneId;
                    option.textContent = `${user.prenom} ${user.nom}`;
                    select.appendChild(option);
                });
        } catch (error) {
            console.error('Erreur lors du chargement des utilisateurs :', error);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        populateUserSelect(); 
    });
    document.addEventListener('DOMContentLoaded', () => {
    populateUserSelect();

    const form = document.getElementById('form-nouveau-message');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const proprietaireId = form.proprietaireId.value;
        const message = form.message.value.trim();
        
        if (!proprietaireId || !message) {
            alert('Veuillez choisir un destinataire et écrire un message.');
            return;
        }

        const personneId = <?= json_encode($_SESSION['user']['id']) ?>;
        const date = new Date().toISOString().slice(0, 10);;
        const isProprietaireMessage = true;

        const payload = {
            message,
            date,
            isProprietaireMessage,
            proprietaireId: parseInt(proprietaireId, 10),
            personneId: parseInt(personneId, 10),
        };
        console.log(payload);
        try {
            const response = await secureFetch('/api/message/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            });


            form.reset();


        } catch (err) {
            console.error('Erreur lors de l’envoi du message :', err);
            alert('Erreur lors de l’envoi du message');
        }
    });
});

</script>
<body>
    <?php include(__DIR__ . '/../includes/header.php'); ?>

    <main class="messagerie-page">
        <h1>Vos messages</h1>

        <section class="nouveau-message-form">
            <h2>Envoyer un nouveau message</h2>
            <form id="form-nouveau-message" class="form-nouveau-message">
                <select name="proprietaireId" id="userSelect" required>
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
                            <input type="hidden" name="proprietaireId" value="<?= $selectedUserId ?? '' ?>">
                            <button type="submit" class="send-button"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include(__DIR__ . '/../includes/footer.php'); ?>


</body>
</html>