<?php

namespace VladimirGrinko\Rabbit\App\Service;

interface NotificationInterface
{
    public function send(string $to, string $subject, string $message): void;
}