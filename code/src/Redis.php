<?php

declare(strict_types=1);

namespace Rrazanov\Hw4;

class Redis
{
    public function sessionStart()
    {
        session_start();
        return $this->getSessionCounter();
    }

    private function getSessionCounter()
    {
        $this->setSessionCounter($_SESSION['count'] ?? 0);
        return $_SESSION['count'];
    }
    private function setSessionCounter(int $value)
    {
        $_SESSION['count'] = ++$value;
    }
}