<?php

declare(strict_types=1);

namespace Evgenyart\Hw12;

interface CommandsInterface
{
    public static function addEvent($params);
    public static function getEvent($params);
    public static function clearEvents();
}
