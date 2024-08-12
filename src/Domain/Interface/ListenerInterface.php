<?php

declare(strict_types=1);

namespace App\Domain\Interface;

interface ListenerInterface
{
    public function handle(EventInterface $event): void;
}
