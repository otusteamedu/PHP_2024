<?php

namespace App\Domain\DTO\Notification;

use Telegram\Bot\Objects\Update;

class UpdateNotification
{
    public function __construct(
        public readonly Update $update,
    ) {
    }

    public function getUpdate(): Update
    {
        return $this->update;
    }
}
