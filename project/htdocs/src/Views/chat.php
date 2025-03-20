<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>
<div id="messages">
    <pre><?= htmlspecialchars($messages) ?></pre>
</div>
<input type="text" id="messageInput" placeholder="Type a message...">
<button onclick="sendMessage()">Send</button>

<script>
    const ws = new WebSocket('ws://host.docker.internal:8080/chat');

    ws.onmessage = function(event) {
        const messagesDiv = document.getElementById('messages');
        messagesDiv.innerHTML += event.data + '<br>';
    };

    function sendMessage() {
        const input = document.getElementById('messageInput');
        const message = input.value;
        ws.send(message);
        input.value = '';
    }
</script>
</body>
</html>