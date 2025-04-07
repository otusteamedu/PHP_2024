<?php

namespace SergeyShirykalov\HomeworkRabbit\Application\UseCase\Consume;

class ReceivedMessage
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

}