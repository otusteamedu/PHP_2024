<?php

declare(strict_types=1);

namespace Kagirova\Hw31\Domain\Service;

use Kagirova\Hw31\Domain\RepositoryInterface\StorageInterface;

interface RabbitMqServiceInterface
{
    public function publish(string $message, string $messageID);

    public function consume(StorageInterface $storage);

    public function close();
}
