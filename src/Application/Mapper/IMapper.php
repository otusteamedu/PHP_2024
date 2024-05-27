<?php

declare(strict_types=1);

namespace App\Application\Mapper;

interface IMapper
{
    public function map(object $object): object;
}
