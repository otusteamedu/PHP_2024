<?php

namespace Kagirova\Hw15\Application;

use Kagirova\Hw15\Domain\RepositoryInterface\StorageInterface;

class GetEventUseCase
{
    private StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function run($options)
    {
        $conditions = [];
        if (!empty($options['c'])) {
            $conditions['conditions'] = json_decode($options['c'], true);
        }
        $event = $this->storage->get($conditions);
        if (!(isset($event))) {
            throw new \Exception('Event not found');
        }
        $event->print();
    }
}
