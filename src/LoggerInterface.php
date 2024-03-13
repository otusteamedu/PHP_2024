<?php

declare(strict_types=1);

namespace Main;

interface LoggerInterface
{
    public function info(string $message): void;
}