<?php

declare(strict_types=1);

namespace App\Analytics\Utility;

final readonly class EventConditionsParser
{
    /**
     * @param string $input
     *
     * @return array<array-key, array{key: string, value: string}>
     */
    public function parse(string $input): array
    {
        preg_match('/conditions:\s*{(.*[^}])}/', $input, $matches);

        $conditions = [];

        $rawConditions = explode(',', $matches[1]);

        foreach ($rawConditions as $rawCondition) {
            $data = explode('=', $rawCondition);

            $conditions[] = [
                'key' => trim($data[0]),
                'value' => trim($data[1])
            ];
        }

        return $conditions;
    }
}
