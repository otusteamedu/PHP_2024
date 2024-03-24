<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024;

class Helper
{
    public static function transformOperator(string $string): array
    {
        $digit = str_replace(['>', '<'], '', $string);

        if (str_contains($string, '<')) {
            return ['lt' => $digit];
        }

        if (str_contains($string, '>')) {
            return ['gt' => $digit];
        }

        return [];
    }
}
