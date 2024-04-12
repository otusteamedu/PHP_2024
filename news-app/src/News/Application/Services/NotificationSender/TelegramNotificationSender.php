<?php

declare(strict_types=1);

namespace App\News\Application\Services\NotificationSender;

use App\Common\Domain\ValueObject\StringValue;
use App\News\Application\Services\NotificationSenderInterface;
use App\NewsCategory\Domain\ValueObject\Subscriber;

class TelegramNotificationSender implements NotificationSenderInterface
{
    public function sendNotification(StringValue $stringValue, Subscriber $subscriber): void
    {
        // TODO:Implement sendNotification() method for send notification by telegram

        $text = $stringValue->value();
        $chatId = $subscriber->getValue()->value();

        //send $text to $chatId
    }
}