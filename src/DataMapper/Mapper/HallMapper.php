<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\Mapper;

use Alogachev\Homework\DataMapper\Entity\Hall;

class HallMapper extends BaseMapper
{
    public function insert(array $data): Hall
    {
        return new Hall(0, '', 0, 0);
    }
}
