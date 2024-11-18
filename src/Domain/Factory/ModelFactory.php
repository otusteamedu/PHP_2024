<?php

namespace App\Domain\Factory;

/**
 * @template T
 */
class ModelFactory
{
    /**
     * @param class-string $modelClass
     * @return T
     */
    public function makeModel(string $modelClass, ...$parameters)
    {
        return new $modelClass(...$parameters);
    }
}
