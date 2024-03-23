<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Traits;

use RailMukhametshin\Hw\Dto\FieldValue;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait ConditionParsableTrait
{
    /**
     * @throws UnknownProperties
     */
    private function parseCondition(string $condition, ?array $fields = null): ?FieldValue
    {
        $array = explode('=', $condition);

        if (count($array) !== 2) {
            return null;
        }

        if ($fields !== null && !in_array($array[0], $fields)) {
            return null;
        }

        return new FieldValue(
            field: $array[0],
            value: $array[1]
        );
    }
}
