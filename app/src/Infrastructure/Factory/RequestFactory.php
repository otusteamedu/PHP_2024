<?php

namespace App\Infrastructure\Factory;



use App\Domain\Entity\Request;
use App\Domain\Factory\RequestFactoryInterface;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Status;

class RequestFactory implements RequestFactoryInterface
{
    public function create(string $holderName, string $holderEmail, string $status = 'REQUESTED'): Request
    {
        return new Request(
            new Name($holderName),
            new Email($holderEmail),
            new Status($status)
        );
    }
}
