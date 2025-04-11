<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Body;
use App\Domain\ValueObject\UserName;

class Lead
{
    public const STATUS_NEW = 'new';
    public const STATUS_QUEUED = 'queued';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_ERROR = 'error';

    private ?int $id = null;

    public function __construct(
        private readonly UserName $userName,
        private readonly Email    $email,
        private readonly Body     $body,
        private string $status = self::STATUS_NEW,
        private ?string $result = null,
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): UserName
    {
        return $this->userName;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getBody(): Body
    {
        return $this->body;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(?string $result): Lead
    {
        $this->result = $result;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): Lead
    {
        $this->status = $status;
        return $this;
    }

}
