<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Repository;

use AnatolyShilyaev\Backend\Domain\Event\Entity\Event;
use AnatolyShilyaev\Backend\Domain\Event\Repository\EventRepositoryInterface;
use AnatolyShilyaev\Backend\Infrastructure\Config\Connection;
use AnatolyShilyaev\Backend\Infrastructure\Mapper\EventMapper;

class EventRepository implements EventRepositoryInterface
{
    private EventMapper $mapper;

    public function __construct()
    {
        $pdo = Connection::get()->connect();
        $this->mapper = new EventMapper($pdo);
    }

    /**
     * @param Event $event
     * @return void
     */
    public function save(Event $event): void
    {
        $eventId = $this->mapper->save($event);
        $reflectionProperty = new \ReflectionProperty(Event::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($event, $eventId);
    }

    // /**
    //  * @return CourtCase[]
    //  */
    // public function getByID(): iterable
    // {
    //     $allCourtCases = $this->mapper->getByID();
    //     return $allCourtCases;
    // }
}
