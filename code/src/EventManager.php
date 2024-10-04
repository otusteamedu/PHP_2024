<?php

namespace Naimushina\EventManager;

class EventManager
{
    /**
     * @var StorageInterface
     */
    private StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Добавление нового события
     * @param int $priority
     * @param array $conditions
     * @param string $event
     * @return mixed
     */
    public function addEvent(int $priority, array $conditions, string $event): mixed
    {
        $event = new Event($priority, $conditions, $event);
        return $this->storage->addEvent($event);
    }

    /**
     * Удаляем все события из хранилища
     * @return mixed
     */
    public function deleteAll(): mixed
    {
        return $this->storage->deleteAll();
    }

    /**
     * Получаем события подходящие по параметрам
     * @param array $params
     * @return array
     */
    public function getByParams(array $params): array
    {
        return $this->storage->getEventsByParams($params);
    }
}
