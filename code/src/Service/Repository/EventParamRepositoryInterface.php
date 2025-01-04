<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\Entity\EventParam;

interface EventParamRepositoryInterface
{
    public function save(EventParam $eventParam);
}