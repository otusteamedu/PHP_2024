<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\Messaging\Consumer;

interface ConsumerInterface
{
    public function consume(): void;
}
