<?php

declare(strict_types=1);

namespace Kagirova\Hw31\Application\ReceiverUseCase;

use Kagirova\Hw31\Domain\RepositoryInterface\StorageInterface;
use Kagirova\Hw31\Infrastucture\Service\RabbitMqService;

class ReceiveDataUseCase
{
    public function __construct(
        private RabbitMqService $service,
        private StorageInterface $storage
    ) {
    }

    public function run()
    {
        $this->service->consume($this->storage);
    }
}
