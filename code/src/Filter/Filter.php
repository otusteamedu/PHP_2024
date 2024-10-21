<?php

namespace IraYu\Hw11\Filter;

abstract class Filter
{
    public function __construct(
        protected string $field,
    ) {
    }
    abstract public function getFilter(): ?array;
}
