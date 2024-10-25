<?php

declare(strict_types=1);

namespace App\Shared\Utility;

class ListFormatter
{
    public static function toTable(array $list): array
    {
        return [
            'headers' => array_keys(current($list)),
            'rows' => array_map(fn(array $item): array => array_values($item), $list)
        ];
    }
}
