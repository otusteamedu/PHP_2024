<?php

declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\DataValueObject;
use App\ValueObject\IdValueObject;
use App\ValueObject\StatusValueObject;

class RequestEntity
{
    public function __construct(
        private IdValueObject $id,
        private DataValueObject $data,
        private StatusValueObject $status
    ) {
    }

    public function setStatus(StatusValueObject $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): StatusValueObject
    {
        return $this->status;
    }

    public function getData(): DataValueObject
    {
        return $this->data;
    }

    public function getId(): IdValueObject
    {
        return $this->id;
    }
}
