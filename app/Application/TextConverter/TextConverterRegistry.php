<?php

namespace App\Application\TextConverter;

class TextConverterRegistry
{
    protected static array $types = [
        'text' => PlainTextConverter::class,
        'html' => HtmlConverter::class,
        'dummy' => DummyConverter::class,
    ];

    public static function get($type)
    {
        if (!isset(self::$types[$type])) {
            return new DummyConverter();
        }
        return new static::$types[$type]();
    }
}
