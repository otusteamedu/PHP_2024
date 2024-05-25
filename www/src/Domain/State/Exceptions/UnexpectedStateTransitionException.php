<?php

declare(strict_types=1);

namespace App\Domain\State\Exceptions;

use App\Domain\DomainException\DomainException;
use App\Domain\State\AbstractState;

class UnexpectedStateTransitionException extends DomainException
{
    public function __construct(
        AbstractState $firstState,
        AbstractState $secondState
    ) {
        $this->message = "Transition from " . $firstState::getName() . " to " . $secondState::getName() . " is not allowed";
        parent::__construct($this->message);
    }
}
