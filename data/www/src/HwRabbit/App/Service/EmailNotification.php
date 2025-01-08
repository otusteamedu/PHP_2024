<?php

namespace VladimirGrinko\Rabbit\App\Service;

class EmailNotification implements NotificationInterface
{
    public function send(string $to, string $subject, string $message): void
    {
        mail($to, $subject, $message);
    }
}
