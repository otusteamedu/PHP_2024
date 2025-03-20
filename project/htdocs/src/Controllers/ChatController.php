<?php

namespace App\Controllers;

use App\Models\Message;

class ChatController
{
    public function index()
    {
        $messages = Message::getAll();
        include __DIR__ . '/../Views/chat.php';
    }

    public function sendMessage($message)
    {
        Message::save($message);
        echo json_encode(['status' => 'success']);
    }
}