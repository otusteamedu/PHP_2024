<?php

declare(strict_types=1);

namespace App\Domain\State\ConcreteStates;

use App\Domain\State\AbstractState;

class Published extends AbstractState
{
    protected array $allowedStates = [
        Deleted::class,
        Updated::class,
    ];

    public static function getName(): string
    {
        return 'published';
    }
}
