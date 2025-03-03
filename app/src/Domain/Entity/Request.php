<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Status;

class Request
{
    private ?int $id = null;

    public function __construct(
        private Name $requesterName,
        private Email $requesterEmail,
        private Status $status,
    ) {
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function getRequesterEmail(): Email
    {
        return $this->requesterEmail;
    }

    public function setRequesterEmail(Email $requesterEmail): void
    {
        $this->requesterEmail = $requesterEmail;
    }

    public function getRequesterName(): Name
    {
        return $this->requesterName;
    }

    public function setRequesterName(Name $requesterName): void
    {
        $this->requesterName = $requesterName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
