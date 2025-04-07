<?php

namespace SergeyShirykalov\HomeworkRabbit\Application\AsyncHandler;

class BankRequest
{

    public function __construct(
        private $userName,
        private $email,
        private $body
    )
    {
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    public function toArray()
    {
        return [
            'userName' => $this->getUserName(),
            'email' => $this->getEmail(),
            'body' => $this->getBody()
        ];
    }
}