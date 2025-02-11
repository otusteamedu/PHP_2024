<?php

namespace App\Service;

use App\Model\Event;

interface Service
{
    public function addEvent(array $event): Event;

    public function getBestEvent(array $conditions): ?Event;

    public function deleteAll(): void;

    public function migrate(): void;
}