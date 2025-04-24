<?php

namespace AnatolyShilyaev\Backend\Domain\Event\Repository;

use AnatolyShilyaev\Backend\Domain\Event\Entity\Event;

interface EventRepositoryInterface
{
    // public function getByID(): iterable;

    public function save(Event $event): void;
}
