<?php

declare(strict_types=1);

namespace App\RendererStrategy;

use App\Contracts\RendererStrategyInterface;
use App\Requests\RenderRequest;
use App\Template;

final readonly class DirRendererStrategy implements RendererStrategyInterface
{
    public function __construct(private RenderRequest $renderRequest)
    {
    }

    public function addRow(Template $template): void
    {
        $template->addRow($this->renderRequest->name . ' | ' . human_filesize($this->renderRequest->size));
    }
}
