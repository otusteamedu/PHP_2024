<?php

namespace App\Domain\Interface\Factory;

/**
 * @template T
 */
interface ResponseFactoryInterface
{
    /**
     * @param class-string $responseClass
     * @param ...$parameters
     * @return T
     */
    public function makeResponse(string $responseClass, ...$parameters);
}
