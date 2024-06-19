<?php

namespace App\Handlers;

use App\Requests\RenderRequest;
use App\Template;

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