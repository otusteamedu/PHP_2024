<?php

declare(strict_types=1);

namespace Hinoho\Battleship\Application\ReceiverUseCase;

use Hinoho\Battleship\Domain\RepositoryInterface\StorageInterface;
use Hinoho\Battleship\Infrastucture\Service\RabbitMqService;

class ReceiveDataUseCase
{
    public function __construct(
        private StorageInterface $storage
    ) {
    }

    public function run()
    {
        $this->service->consume($this->storage);
    }
}
