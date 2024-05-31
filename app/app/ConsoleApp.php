<?php

declare(strict_types=1);

namespace Rmulyukov\Hw;

use Rmulyukov\Hw\Application\UseCase\Consume\ConsumeUseCase;

final readonly class ConsoleApp
{
    public function __construct(
        private ConsumeUseCase $useCase
    ) {
    }

    public function run(): void
    {
        ($this->useCase)();
    }
}
