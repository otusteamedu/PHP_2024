<?php

namespace SergeyShirykalov\HomeworkRabbit\Application\UseCase\SendUserRequest;

readonly class SendBankRequestRequest
{
    public function __construct(
        private string $userName,
        private string $email,
        private string $body,
    )
    {
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBody(): string
    {
        return $this->body;
    }

}
