<?php

namespace App\Application\ChainOfResponsibility;

class Middleware
{
    public function __construct(private CookingProcessHandler $firstCookingProcessHandler)
    {
    }

    public function process(CookingProcessRequest $request)
    {
        $this->firstCookingProcessHandler->handle($request);
    }

}