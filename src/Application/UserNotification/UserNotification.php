<?php

namespace SergeyShirykalov\HomeworkRabbit\Application\UserNotification;

readonly class UserNotification
{
    public function __construct(
        private string $email,
        private string $message
    )
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

}