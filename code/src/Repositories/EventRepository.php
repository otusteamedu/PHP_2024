<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Repositories;

use Asyrovatkin\Hw11\Models\Event;
use Asyrovatkin\Hw11\Settings\Config;
use Asyrovatkin\Hw11\Storages\Storage;

class EventRepository
{

    private Storage $db;

    public function __construct()
    {
        $this->db = (new Config())->getCurrentDb();
    }

    public function addEvent(Event $event)
    {
        $this->db->addEvent($event);
    }

    public function getEventIdsByParamsWithMaxPriority(array $params): array
    {
        return $this->db->getEventIdsByParamsWithMaxPriority($params);
    }

    public function clearStorage()
    {
        $this->db->clearStorage();
    }

}