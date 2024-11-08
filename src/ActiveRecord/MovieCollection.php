<?php

declare(strict_types=1);

namespace VladimirGrinko\ActiveRecord;

class MovieCollection extends \ArrayObject
{
    public function offsetSet(int $index, Movie $value)
    {
        parent::offsetSet($index, $value);
    }
}