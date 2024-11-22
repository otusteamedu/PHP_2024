<?php

namespace App\Domain\Contract\Application\Factory;

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
