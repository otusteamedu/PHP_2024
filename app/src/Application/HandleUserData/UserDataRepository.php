<?php

namespace AnatolyShilyaev\App\Application\HandleUserData;

use AnatolyShilyaev\App\Domain\Request\Request;

interface UserDataRepository
{
    public function handleUserData(Request $request): string;
}
