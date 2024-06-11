<?php

declare(strict_types=1);

namespace App\Application\Mapper;

interface IObjectMapper
{
    public function map(object $object, string $format): object|array;
}
