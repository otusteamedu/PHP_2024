<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

interface IGetFormatedDuration
{
    public function getFormatedDuration(): string;
}
