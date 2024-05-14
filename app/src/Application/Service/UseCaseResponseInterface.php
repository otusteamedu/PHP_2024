<?php

declare(strict_types=1);

namespace App\Application\Service;

interface UseCaseResponseInterface
{
    public function getData(): mixed;
}
