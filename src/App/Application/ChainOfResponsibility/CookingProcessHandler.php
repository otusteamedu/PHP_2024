<?php

namespace App\Application\ChainOfResponsibility;

abstract class CookingProcessHandler
{
    public function __construct(private ?CookingProcessHandler $nextHandler = null)
    {
    }

    public function setNext(CookingProcessHandler $nextHandler)
    {
        $this->nextHandler = $nextHandler;
    }

    public function handle(CookingProcessRequest $request): void {
        $this->nextHandler?->handle($request);
    }
}