<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\Repository;

use Rmulyukov\Hw\Application\Event\Criteria;
use Rmulyukov\Hw\Application\Event\Event;

interface EventQueryRepositoryInterface
{
    public function getByCriteria(Criteria $criteria, Criteria ...$criterias): Event;
}
