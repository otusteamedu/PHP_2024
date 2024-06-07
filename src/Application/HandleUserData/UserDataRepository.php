<?php

namespace AKornienko\Php2024\Application\HandleUserData;

use AKornienko\Php2024\Domain\UserDataRequest\UserDataRequest;

interface UserDataRepository
{
    public function handleUserData(UserDataRequest $request): string;
}
