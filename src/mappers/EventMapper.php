<?php

declare(strict_types=1);

namespace hw15\mappers;

use hw15\entities\EventEntity;

class EventMapper
{
    public function dataToEntity(array $data): EventEntity
    {
        return new EventEntity(
            (int)($data["priority"] ?? 0),
            $data["conditions"] ?? [],
            $data["event"] ?? ''
        );
    }
}
