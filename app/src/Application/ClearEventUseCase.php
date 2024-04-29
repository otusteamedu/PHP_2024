<?php

namespace Kagirova\Hw15\Application;

use Kagirova\Hw15\Domain\RepositoryInterface\StorageInterface;

class ClearEventUseCase
{
    private StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function run() {
        $this->storage->clear();
    }
}
