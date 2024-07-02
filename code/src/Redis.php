<?php
declare(strict_types=1);

namespace Pyivanov\hw4;

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
    private function setSessionCounter(int $value): void
    {
        $_SESSION['count'] = ++$value;
    }
}