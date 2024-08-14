<?php

declare(strict_types=1);

namespace Pyivanov\hw4;

class RedisCheck
{
    private const SESSION_ID = 'test';

    /**
     */
    public function sessionStart()
    {
        session_id(self::SESSION_ID);
        session_start();
        return $this->getSessionCounter();
    }

    private function getSessionCounter()
    {
        $this->setSessionCounter($_SESSION['count'] ?? 0);
        return $_SESSION['count'];
    }
    private function setSessionCounter(int $value): void
    {
        $_SESSION['count'] = ++$value;
    }
}
