<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\Command;

interface CommandInterface
{
    public function execute(): void;
}
