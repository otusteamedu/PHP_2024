<?php

namespace AKornienko\Php2024;

use AllowDynamicProperties;

#[AllowDynamicProperties] class SearchParam
{
    /**
     * @throws \Exception
     */
    public function __construct($key, $value)
    {
        if ($key === 'title') {
            $this->key = $key;
            $this->type = 'string';
            $this->value = $value;
        } else if ($key === 'price') {
            $this->key = $key;
            $this->type = 'number';
            $this->value = $value;
        } else if ($key === 'price-range') {
            $this->key = 'price';
            $this->type = 'range';
            $valueRaw = explode("-", $value);
            if (count($valueRaw) === 2) {
                $this->valueMin = $valueRaw[0];
                $this->valueMax = $valueRaw[1];
            }
        } else {
            throw new \Exception('Undefined search parameter');
        }
    }
}