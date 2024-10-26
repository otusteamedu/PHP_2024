<?php

declare(strict_types=1);

namespace App\Shared\Utility;

class StringFormatter
{
    public static function fromSnakeCaseToCamelCase(string $string): string
    {
        return lcfirst(
            implode(
                '',
                array_map(
                    'ucfirst',
                    explode(
                        '_',
                        strtolower($string)
                    )
                )
            )
        );
    }
}
