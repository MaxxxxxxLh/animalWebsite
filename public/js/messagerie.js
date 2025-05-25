document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('userSelect');
    const conversationsList = document.getElementById('conversationsList');
    const messagesContainer = document.getElementById('messagesContainer');

    let currentConversationId = null;

    async function populateUserSelect() {
        try {
            const users = await secureFetch('/api/users/findAll');
            users
                .filter(user => user.personneId !== CURRENT_USER_ID)
                .forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.personneId;
                    option.textContent = `${user.prenom} ${user.nom}`;
                    select.appendChild(option);
                });
        } catch (err) {
            console.error("Erreur lors de la récupération des utilisateurs :", err);
        }
    }

    async function loadConversations() {
        try {
            const conversations = await secureFetch(`/api/message/conversations?userId=${CURRENT_USER_ID}`);
            conversationsList.innerHTML = ''; 
    
            if (!conversations || conversations.length === 0) {
                conversationsList.textContent = "Vous n'avez aucune conversation.";
                messagesContainer.innerHTML = '';
                return;
            }
    
            const uniqueConversationsMap = new Map();
            conversations.forEach(conv => {
                if (!uniqueConversationsMap.has(conv.conversationId)) {
                    uniqueConversationsMap.set(conv.conversationId, conv);
                }
            });
    
            const uniqueConversations = Array.from(uniqueConversationsMap.values());
    
            uniqueConversations.forEach(conv => {
                const div = document.createElement('div');
                div.className = 'contact-item';
                div.textContent = `${conv.interlocuteurPrenom} ${conv.interlocuteurNom}`;
                div.dataset.conversationId = conv.conversationId;
                
                div.addEventListener('click', () => {
                    currentConversationId = conv.conversationId;
                    loadMessages(conv.conversationId);
                    highlightSelectedConversation(conv.conversationId);
                    document.querySelector('input[name="proprietaireId"]').value = conv.interlocuteurId;
                });
    
                conversationsList.appendChild(div);
            });
    
            if (!currentConversationId && uniqueConversations.length > 0) {
                currentConversationId = uniqueConversations[0].conversationId;
                loadMessages(currentConversationId);
                highlightSelectedConversation(currentConversationId);
                document.querySelector('input[name="proprietaireId"]').value = uniqueConversations[0].interlocuteurId;
            }
    
        } catch (err) {
            console.error('Erreur chargement conversations:', err);
            conversationsList.textContent = "Erreur chargement conversations.";
        }
    }
    

    async function loadMessages(conversationId) {
        try {
            const messages = await secureFetch(`/api/message/conversation?conversationId=${conversationId}`);
            messagesContainer.innerHTML = '';

            if (messages.length === 0) {
                messagesContainer.textContent = "Aucun message dans cette conversation.";
                return;
            }

            messages.forEach(msg => {
                const div = document.createElement('div');
                div.className = msg.senderId === CURRENT_USER_ID ? 'message sent' : 'message received';
                div.innerHTML = `
                    <div>${msg.content}</div>
                    <div class="message-time">${new Date(msg.sentAt).toLocaleString()}</div>
                `;
                messagesContainer.appendChild(div);
            });

            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        } catch (err) {
            console.error('Erreur chargement messages:', err);
            messagesContainer.textContent = "Erreur chargement messages.";
        }
    }

    function highlightSelectedConversation(conversationId) {
        document.querySelectorAll('.contact-item').forEach(div => {
            if (parseInt(div.dataset.conversationId) === conversationId) {
                div.classList.add('active');
            } else {
                div.classList.remove('active');
            }
        });
    }

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
        
            const message = form.message.value.trim();
            let proprietaireId = null;

            const hiddenInput = form.querySelector('input[name="proprietaireId"]');
            if (hiddenInput) {
                proprietaireId = parseInt(hiddenInput.value);
            } else if (form.id === 'form-nouveau-message') {
                proprietaireId = parseInt(select.value);
            }
            if (!message || !proprietaireId) {
                alert("Veuillez choisir un destinataire et écrire un message.");
                return;
            }
        
            const payload = {
                senderId: CURRENT_USER_ID,
                receiverId: proprietaireId,
                content: message
            };
        
            try {
                const response = await secureFetch('/api/message/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
        
                form.reset();

                await loadConversations();

                const id = parseInt(response.conversationId);
                currentConversationId = id;
                loadMessages(id);
                highlightSelectedConversation(id);
                
                const hidden = document.querySelector('input[name="proprietaireId"]');
                if (hidden) {
                    hidden.value = proprietaireId;
                }
            

            } catch (err) {
                console.error("Erreur lors de l'envoi du message :", err);
                alert("Échec de l'envoi du message.");
            }
        });
    });

    populateUserSelect();
    loadConversations();
});
