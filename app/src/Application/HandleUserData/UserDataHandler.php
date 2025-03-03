<?php

namespace AnatolyShilyaev\App\Application\HandleUserData;

use AnatolyShilyaev\App\Domain\Request\Request;

readonly class UserDataHandler
{
    public function __construct(private UserDataRepository $repository)
    {
        //empty construct
    }

    public function __invoke(Request $request): string
    {
        return $this->repository->handleUserData($request);
    }
}
