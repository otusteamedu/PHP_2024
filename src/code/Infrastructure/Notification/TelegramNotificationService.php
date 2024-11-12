<?php

declare(strict_types=1);

namespace Infrastructure\Notification;

use Domain\Notification\Services\NotificationServiceInterface;
use Domain\User\Entities\User;

class TelegramNotificationService implements NotificationServiceInterface
{
    public function send(User $user, string $message): void
    {
        // Логика отправки уведомления в Telegram
        $telegramChatId = $user->getTelegramChatId();

        // Пример реализации:
        // TelegramService::sendMessage($telegramChatId, $message);
    }
}
