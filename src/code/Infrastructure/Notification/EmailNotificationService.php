<?php

declare(strict_types=1);

namespace Infrastructure\Notification;

use Domain\Notification\Services\NotificationServiceInterface;
use Domain\User\Entities\User;

class EmailNotificationService implements NotificationServiceInterface
{
    public function send(User $user, string $message): void
    {
        // Логика отправки уведомления по электронной почте
        $email = $user->getEmail(); // Предполагается, что у пользователя есть метод getEmail()

        // Пример реализации:
        // EmailService::sendEmail($email, $message);
    }
}
