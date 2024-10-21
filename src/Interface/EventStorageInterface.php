<?php

namespace Komarov\Hw11\Interface;

interface EventStorageInterface
{
    public function addEvent(array $event);
    public function clearEvents();
    public function getBestEvent(array $params);
}
