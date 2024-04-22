<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Request;

class RequestValidationHelper
{
    public function validateConditionArg(array $conditions): array
    {
        foreach ($conditions as $condition) {
            $position = mb_strpos($condition, '=');
            if ($position === false || $position === 0) {
                throw new RequestValidationException('Условие должно быть задано в формате "name=value."');
            }
        }

        $result = [];
        foreach ($conditions as $condition) {
            list($conditionName, $conditionValue) = explode('=', $condition, 2);
            $result[$conditionName] = $conditionValue;
        }

        return $result;
    }
}
