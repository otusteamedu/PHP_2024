<?php
require 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class ChatServer implements MessageComponentInterface {
    protected $clients;
    protected $usernames;

    public function __construct() {
        $this->clients = new \SplObjectStorage();
        $this->usernames = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        if ($data['type'] === 'join') {
            // Сохраняем имя пользователя
            $this->usernames[$from->resourceId] = $data['username'];

            // Уведомляем всех о новом пользователе
            $this->broadcastUsers();
        } elseif ($data['type'] === 'message') {
            // Отправляем сообщение всем клиентам, ВКЛЮЧАЯ отправителя
            foreach ($this->clients as $client) {
                $client->send(json_encode([
                    'type' => 'message',
                    'sender' => $data['sender'],
                    'message' => $data['message']
                ]));
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Удаляем пользователя из списка
        unset($this->usernames[$conn->resourceId]);
        $this->clients->detach($conn);

        // Уведомляем всех об удалении пользователя
        $this->broadcastUsers();

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    private function broadcastUsers() {
        // Отправляем обновленный список пользователей всем клиентам
        $userList = array_values($this->usernames);
        foreach ($this->clients as $client) {
            $client->send(json_encode([
                'type' => 'users',
                'users' => $userList
            ]));
        }
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatServer()
        )
    ),
    38081,
    '0.0.0.0'
);

echo "WebSocket server is running on ws://0.0.0.0:38081\n";
$server->run();