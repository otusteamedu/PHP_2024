<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\Entity\Event;
use App\Service\Entity\EventParam;

interface EventRepositoryInterface
{
    public function save(Event $event);

    public function removeAll();

    /**
     * @param EventParam[] $params
     */
    public function getRelevant(array $eventParams);
}