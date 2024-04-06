<?php

namespace AKornienko\Php2024;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class SearchParam
{
    public readonly string $key;
    public readonly string $type;
    public readonly string|array $value;

    private function __construct($key, $type, $value)
    {
        $this->key = $key;
        $this->type = $type;
        $this->value = $value;
    }

    public static function title($value): SearchParam
    {
        return new self('title', 'string', $value);
    }

    public static function price($value): SearchParam
    {
        return new self('price', 'number', $value);
    }

    /**
     * @throws \Exception
     */
    public static function priceRange($value): SearchParam
    {
        $valueRaw = explode("-", $value);
        if (count($valueRaw) !== 2) {
            throw new \Exception('Invalid range');
        }
        return new self('price', 'range', $valueRaw);
    }
}
