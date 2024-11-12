<?php

declare(strict_types=1);

namespace Domain\Notification\Services;

use Domain\User\Entities\User;

interface NotificationServiceInterface
{
    public function send(User $user, string $message): void;
}
