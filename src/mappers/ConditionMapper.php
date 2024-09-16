<?php

declare(strict_types=1);

namespace hw15\mappers;

use hw15\entities\ConditionEntity;

class ConditionMapper
{
    public function dataToEntity(array $data): ConditionEntity
    {
        return new ConditionEntity(
            $data["params"] ?? []
        );
    }
}
