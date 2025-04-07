<?php

namespace SergeyShirykalov\HomeworkRabbit\Infrastructure\EmailNotification;

use SergeyShirykalov\HomeworkRabbit\Application\UserNotification\UserNotification;
use SergeyShirykalov\HomeworkRabbit\Application\UserNotification\UserNotificationInterface;

class EmailNotification implements UserNotificationInterface
{

    public function sendNotification(UserNotification $notification): void
    {
        $sendResult = mail($notification->getEmail(), 'Message received by the bank', $notification->getMessage());
        if (!$sendResult) {
            print("Failed to send notification" . PHP_EOL);
        } else {
            print("Email notification sent." . PHP_EOL);
        }
    }
}