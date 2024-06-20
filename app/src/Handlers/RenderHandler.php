<?php

namespace App\src\Handlers;

use App\src\Requests\RenderRequest;
use App\src\Template;

abstract class RenderHandler
{
    public function __construct(private ?RenderHandler $nextHandler = null)
    {
    }

    public function setNext(RenderHandler $nextHandler): RenderHandler
    {
        $this->nextHandler = $nextHandler;

        return $nextHandler;
    }

    public function handle(RenderRequest $renderRequest, Template $template): void
    {
        $this->nextHandler?->handle($renderRequest, $template);
    }
}