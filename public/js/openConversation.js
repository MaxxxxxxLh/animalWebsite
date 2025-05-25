async function openConversation(user1, user2) {
    if (!user1) {
        alert('Vous devez être connecté pour contacter un utilisateur.');
        window.location.href = '/login';
        return;
    }
    try {
        const response = await secureFetch(`/api/message/conversationBetween?user1=${user1}&user2=${user2}`);
        
        if (response && response.conversation_id) {
            window.location.href = `/messagerie?conversationId=${response.conversation_id}`;
        } else {
            const createResp = await secureFetch('/api/message/create', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    senderId: user1,
                    receiverId: user2,
                    content: '' 
                })
            });

            if (createResp && createResp.conversationId) {
                window.location.href = `/messagerie?conversationId=${createResp.conversationId}`;
            } else {
                alert("Impossible de démarrer la conversation.");
            }
        }
    } catch (error) {
        console.error(error);
        alert("Erreur lors de l'ouverture de la conversation.");
    }
}
