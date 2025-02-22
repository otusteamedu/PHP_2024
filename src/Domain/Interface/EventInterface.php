<?php

declare(strict_types=1);

namespace App\Domain\Interface;

interface EventInterface
{
    public function getSource();

    public function getPayload();
}
