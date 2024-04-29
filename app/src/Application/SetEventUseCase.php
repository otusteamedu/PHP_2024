<?php


namespace Kagirova\Hw15\Application;

use Kagirova\Hw15\Domain\Entity\Event;
use Kagirova\Hw15\Domain\RepositoryInterface\StorageInterface;

class SetEventUseCase
{
    private StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function run($options)
    {
        $priority = 0;
        $conditions = [];
        $name = '';
        if (!empty($options['p'])) {
            $priority = $options['p'];
        }
        if (!empty($options['c'])) {
            $conditions = json_decode($options['c'], true);
        }
        if (!empty($options['e'])) {
            $name = $options['e'];
        }
        $event = new Event($priority, $conditions, $name);
        $this->storage->set($event);
    }
}
