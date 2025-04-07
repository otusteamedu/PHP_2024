<?php

namespace SergeyShirykalov\HomeworkRabbit\Domain\Entity;

use SergeyShirykalov\HomeworkRabbit\Domain\ValueObject\Email;
use SergeyShirykalov\HomeworkRabbit\Domain\ValueObject\UserData;
use SergeyShirykalov\HomeworkRabbit\Domain\ValueObject\UserName;

readonly class BankRequest
{

    public function __construct(
        private UserName $userName,
        private Email    $email,
        private UserData $userData,
    )
    {
    }

    public function getUserName(): UserName
    {
        return $this->userName;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getUserData(): UserData
    {
        return $this->userData;
    }

}