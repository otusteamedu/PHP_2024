<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\Factory;

use Rmulyukov\Hw\Application\Event\Criteria;
use Rmulyukov\Hw\Application\Event\Event;

final class EventFactory
{
    public function create(int $id, int $priority, array $criterias): Event
    {
        return new Event($id, $priority, ...$this->createCriteria($criterias));
    }

    public function createCriteria(array $criterias): array
    {
        $criteria = [];
        foreach ($criterias as $name => $value) {
            $criteria[] = new Criteria($name, $value);
        }
        return $criteria;
    }
}
