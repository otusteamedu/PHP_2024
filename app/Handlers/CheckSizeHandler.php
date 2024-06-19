<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Requests\RenderRequest;
use App\Template;

class CheckSizeHandler extends RenderHandler
{
    public function __construct(
        private readonly int $maxItemShowSize = 100000,
        ?RenderHandler $nextHandler = null
    )
    {
        parent::__construct($nextHandler);
    }

    public function handle(RenderRequest $renderRequest, Template $template): void
    {
        if ($renderRequest->size > $this->maxItemShowSize) {
            return;
        }

        parent::handle($renderRequest, $template);
    }
}
