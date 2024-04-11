<?php

declare(strict_types=1);

namespace App\News\Application\Factory;

use App\News\Application\Services\NotificationSender\EmailNotificationSender;
use App\News\Application\Services\NotificationSender\TelegramNotificationSender;
use App\News\Application\Services\NotificationSenderInterface;
use InvalidArgumentException;

class NotificationSenderFactory
{
    private array $senders;

    public function __construct()
    {
        $this->senders = [
            'telegram' => new TelegramNotificationSender(),
            'email' => new EmailNotificationSender()
        ];
    }

    public function getSenderByType(string $type): NotificationSenderInterface
    {
        $sender = $this->senders[$type] ?? null;

        if ($sender === null) {
            throw new InvalidArgumentException(sprintf('Invalid sender type "%s"', $type));
        }

        return $sender;
    }
}