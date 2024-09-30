<?php

namespace Service;

class SessionManager
{
    public function __construct()
    {
        session_start();
    }

    public function setMessage($message): void
    {
        $_SESSION['message'] = $message;
    }

    public function getMessage()
    {
        return isset($_SESSION['message']) ? $_SESSION['message'] : 'Сессия пуста.';
    }

    public function handleSetMessage(): void
    {
        if (isset($_GET['set'])) {
            $this->setMessage('Эти данные сессии хранятся в Redis.');
        }
    }

    public function getFormattedMessage(): string
    {
        $message = $this->getMessage();
        return 'Сообщения: ' . htmlspecialchars($message) . PHP_EOL;
    }
}