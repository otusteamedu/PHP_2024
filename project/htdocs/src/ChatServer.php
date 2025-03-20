<?php

namespace App;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class ChatServer implements MessageComponentInterface
{
    public $clients;
    protected $usernames;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
        $this->usernames = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if ($data['type'] === 'join') {
            $this->usernames[$from->resourceId] = $data['username'];
            $this->broadcastUsers();
        } elseif ($data['type'] === 'message') {
            foreach ($this->clients as $client) {
                $client->send(json_encode([
                    'type' => 'message',
                    'sender' => $data['sender'],
                    'message' => $data['message']
                ]));
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        unset($this->usernames[$conn->resourceId]);
        $this->clients->detach($conn);
        $this->broadcastUsers();
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }

    private function broadcastUsers()
    {
        $userList = array_values($this->usernames);
        foreach ($this->clients as $client) {
            $client->send(json_encode([
                'type' => 'users',
                'users' => $userList
            ]));
        }
    }
}