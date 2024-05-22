<?php

declare(strict_types=1);

namespace App\Domain\State\Exceptions;

use App\Domain\DomainException\DomainException;

class UnexpectedStateScalarMappingException extends DomainException
{
    public function __construct(
        int $scalar
    ) {
        $this->message =  "State to $scalar is unknown";
        parent::__construct($this->message);
    }
}