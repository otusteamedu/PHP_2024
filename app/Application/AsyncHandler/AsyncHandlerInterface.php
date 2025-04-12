<?php

namespace App\Application\AsyncHandler;

interface AsyncHandlerInterface
{
    public function sendRequest(LeadRequest $request): void;

}
