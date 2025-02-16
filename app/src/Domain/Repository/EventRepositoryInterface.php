<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Domain\Repository;

use SlavaMakhov\OtusArchitectureApp\Domain\Entity\Event;

interface EventRepositoryInterface
{
    /**
     * Метод список сущностей
     *
     * @return iterable
     */
    public function findAll(): iterable;

    /**
     * Метод получает сущность по её id
     *
     * @param int $id
     *
     * @return Event|null
     */
    public function findById(int $id): ?Event;

    /**
     * Метод сохраняет сущность
     *
     * @param Event $event
     *
     * @return void
     */
    public function save(Event $event): void;

    /**
     * Метод удаляет сущность
     *
     * @param Event $event
     *
     * @return void
     */
    public function delete(Event $event): void;
}
