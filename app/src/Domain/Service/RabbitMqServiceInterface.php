<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Service;

interface RabbitMqServiceInterface
{
    public function publish(string $msg);

    public function consume();

    public function close();
}
