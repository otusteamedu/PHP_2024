<?php

namespace App\Application\Factory;

use App\Domain\Contract\Application\Factory\ResponseFactoryInterface;

/**
 * @template T
 */
class CommonResponseFactory implements ResponseFactoryInterface
{
    /**
     * @param class-string $responseClass
     * @param ...$parameters
     * @return T
     */
    public function makeResponse(string $responseClass, ...$parameters)
    {
        return new $responseClass(...$parameters);
    }
}
