<?php

namespace Naimushina\EventManager;

interface StorageInterface
{
    /**
     * Очищаем все доступные события в хранилище
     * @return mixed
     */
    public function deleteAll(): mixed;

    /**
     * Добавляем событие в систему хранения
     * @param Event $event
     * @return mixed
     */
    public function addEvent(Event $event): bool;

    /**
     * Получаем события удовлетворяющие параметры отсортированные от большего к меньшему приоритету
     * @param array $params
     * @return mixed
     */
    public function getEventsByParams(array $params): array;

}