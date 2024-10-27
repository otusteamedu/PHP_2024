<?php

namespace Src;

interface StorageInterface {
    public function addEvent($priority, $conditions, $event);
    public function clearEvents();
    public function getBestEvent($params);
}
