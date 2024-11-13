<?php

declare(strict_types=1);

namespace App\Domain\Entity\MethodServing;

use App\Domain\Entity\MethodServing\MethodServingInterface;

class Package implements MethodServingInterface
{
    public function getName(): string
    {
        return 'Package';
    }
}
