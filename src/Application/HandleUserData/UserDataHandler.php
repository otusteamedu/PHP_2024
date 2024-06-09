<?php

namespace AKornienko\Php2024\Application\HandleUserData;

use AKornienko\Php2024\Domain\UserDataRequest\UserDataRequest;

readonly class UserDataHandler
{
    public function __construct(private UserDataRepository $repository)
    {
    }

    public function __invoke(UserDataRequest $request): string
    {
        return $this->repository->handleUserData($request);
    }
}
