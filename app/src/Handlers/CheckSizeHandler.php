<?php

declare(strict_types=1);

namespace App\src\Handlers;

use App\src\Requests\RenderRequest;
use App\src\Template;

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
