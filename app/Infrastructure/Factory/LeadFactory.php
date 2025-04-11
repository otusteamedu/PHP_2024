<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\Lead;
use App\Domain\Factory\LeadFactoryInterface;
use App\Domain\ValueObject\Body;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\UserName;

class LeadFactory implements LeadFactoryInterface
{

    public function create(
        string $userName,
        string $email,
        string $body,
        string $status = Lead::STATUS_NEW,
        ?string $result = null,
    ): Lead
    {
        return new Lead(
            new UserName($userName),
            new Email($email),
            new Body($body),
            $status,
            $result
        );
    }
}
