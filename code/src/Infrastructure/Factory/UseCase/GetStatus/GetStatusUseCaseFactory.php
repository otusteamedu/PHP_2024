<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Factory\UseCase\GetStatus;

use RedisException;
use Viking311\Api\Application\UseCase\GetStatus\GetStatusUseCase;
use Viking311\Api\Infrastructure\Factory\Repository\EventRepositoryFactory;

class GetStatusUseCaseFactory
{
    /**
     * @throws RedisException
     */
    public static function createInstance(): GetStatusUseCase
    {
        $repository = EventRepositoryFactory::createInstance();

        return new GetStatusUseCase($repository);
    }
}
