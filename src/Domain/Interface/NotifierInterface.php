<?php

declare(strict_types=1);

namespace App\Domain\Interface;

interface NotifierInterface
{
    public function notify(mixed $data): void;
}
