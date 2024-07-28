<?php

namespace App\Domain\Contract;

interface ConsumerInterface
{
    public function consume(): void;
}