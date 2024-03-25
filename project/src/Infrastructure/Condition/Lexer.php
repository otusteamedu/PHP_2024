<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Infrastructure\Condition;

use Doctrine\Common\Lexer\AbstractLexer;

class Lexer extends AbstractLexer
{
    public const T_NONE              = 1;
    public const T_INTEGER           = 2;
    public const T_STRING            = 3;
    public const T_FLOAT             = 4;
    public const T_BOOL             = 4;
    public const T_EQUALS            = 5;
    public const T_COMMA            = 6;

    public const T_NAME              = 100;

    protected function getCatchablePatterns()
    {
        return [
            '[a-z_][a-z0-9_]*', // name
            '[+-]?(?:[0-9]+(?:[\.][0-9]+)*)(?:e[+-]?[0-9]+)?', // numbers
            '"(?:[^"]|"")*"', // quoted strings
            '[,]', // separator
        ];
    }

    protected function getNonCatchablePatterns()
    {
        return ['\s+'];
    }

    protected function getType(string &$value)
    {
        switch (true) {
            // Recognize numeric values
            case is_numeric($value):
                if (str_contains($value, '.') || stripos($value, 'e') !== false) {
                    return self::T_FLOAT;
                }

                return self::T_INTEGER;

            // Recognize quoted strings
            case $value[0] === '"':
                $value = substr($value, 1, strlen($value) - 2);

                return self::T_STRING;

            case $value === 'true' || $value === 'false':
                return self::T_BOOL;

            // Recognize names
            case ctype_alpha($value[0]) || $value[0] === '_':
                return self::T_NAME;

            // Recognize symbols
            case $value === '=':
                return self::T_EQUALS;
            case $value === ',':
                return self::T_COMMA;
        }

        return self::T_NONE;
    }
}
