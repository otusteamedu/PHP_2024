<?php

declare(strict_types=1);

namespace App\Domain\Entity\ApiRequest;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ApiRequestNotFoundException extends DomainRecordNotFoundException
{
    public function __construct(int $id)
    {
        $this->message = "The ApiRequest with id $id not found.";
    }
}
