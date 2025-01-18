<?php

namespace KRudenko\Otus\Service;

class SessionService
{
    public function processSession(): string
    {
        if (!isset($_SESSION['count'])) {
            $_SESSION['count'] = 0;
        }
        $_SESSION['count']++;
        $sessionId = session_id();
        return "Session ID: $sessionId" . PHP_EOL . "Session count: " . $_SESSION['count'];
    }
}
