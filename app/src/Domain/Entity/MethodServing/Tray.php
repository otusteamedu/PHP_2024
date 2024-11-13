<?php

declare(strict_types=1);

namespace App\Domain\Entity\MethodServing;

use App\Domain\Entity\MethodServing\MethodServingInterface;

class Tray implements MethodServingInterface
{
    public function getName(): string
    {
        return 'Tray';
    }
}
