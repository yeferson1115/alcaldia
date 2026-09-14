
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Administración de Chats</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #chat-list { width: 30%; float: left; border-right: 1px solid #ccc; padding: 10px; }
        #chat-window { width: 70%; float: left; padding: 10px; }
        .chat-item { cursor: pointer; padding: 5px; border-bottom: 1px solid #ddd; }
        .chat-item:hover { background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Administración de Chats</h1>
    
    <div id="chat-list">
        <h3>Chats Activos</h3>
        <div id="chats">
            <!-- Los chats activos se cargarán aquí -->
        </div>
    </div>

    <div id="chat-window">
        <h3>Chat Seleccionado</h3>
        <div id="messages"></div>
        <input type="text" id="message" placeholder="Escribe un mensaje...">
        <button onclick="sendMessage()">Enviar</button>
    </div>

    <script>
        let chatId = null;

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        // Cargar chats activos automáticamente
        function loadActiveChats() {
            $.get('/chat/active', function(chats) {
                $('#chats').html('');
                chats.forEach(chat => {
                    $('#chats').append(`
                        <div class="chat-item" onclick="loadMessages(${chat.id})">
                            Chat #${chat.id} - Status: ${chat.status}
                        </div>
                    `);
                });
            });
        }

        // Cargar mensajes del chat seleccionado
        function loadMessages(id) {
            chatId = id;
            $.get(`/chat/${chatId}/messages`, function(messages) {
                $('#messages').html('');
                messages.forEach(msg => {
                    $('#messages').append(`<p><strong>${msg.user_id ? 'Agente' : 'Visitante'}:</strong> ${msg.message}</p>`);
                });
            });
            $.post(`/chat/attend/${chatId}`, function() {
                loadChats();  // Actualizar la lista de chats
            });
        }

        // Enviar mensaje
        function sendMessage() {
            if (!chatId) return alert("Selecciona un chat primero");
            
            let message = $('#message').val();
            $.post('/chat/send', { chat_id: chatId, message: message }, function() {
                $('#message').val('');
                loadMessages(chatId);
            });
        }

        // Actualizar la lista de chats cada 3 segundos
        setInterval(loadActiveChats, 2000); 
        setInterval(() => {
            if (chatId) {
                loadMessages(chatId);  // Cargar los mensajes del chat seleccionado
            }
        }, 3000); // Esto actualizará la lista de chats activos cada 3 segundos
    </script>
</body>
</html>