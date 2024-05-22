<?php

declare(strict_types=1);

namespace App\Domain\State\ConcreteStates;

use App\Domain\State\AbstractState;

class Draft extends AbstractState
{
    protected array $allowedStates = [
        Moderation::class,
        Deleted::class,
    ];

    public static function getName(): string
    {
        return 'draft';
    }

    public function __toString()
    {
        return 'draft';
    }
}
