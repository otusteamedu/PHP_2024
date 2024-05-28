<?php

namespace Ahar\Hw16\builder;

class Product
{
    private $parts = [];

    public function addPart($part)
    {
        $this->parts[] = $part;
    }

    public function listParts()
    {
        echo "Продукт состоит из: " . implode(', ', $this->parts) . "\n";
    }
}
