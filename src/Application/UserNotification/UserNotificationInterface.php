<?php

namespace SergeyShirykalov\HomeworkRabbit\Application\UserNotification;

interface UserNotificationInterface
{
    public function sendNotification(UserNotification $notification);
}