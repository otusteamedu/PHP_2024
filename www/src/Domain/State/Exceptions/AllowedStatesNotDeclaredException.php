<?php

declare(strict_types=1);

namespace App\Domain\State\Exceptions;

use App\Domain\DomainException\DomainException;
use App\Domain\State\AbstractState;

class AllowedStatesNotDeclaredException extends DomainException
{
    public function __construct(AbstractState $stateClass)
    {
        $this->message = $stateClass::class . " must declare \$allowedStates property";
        parent::__construct($this->message);
    }
}
