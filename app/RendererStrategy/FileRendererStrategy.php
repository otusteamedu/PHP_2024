<?php

declare(strict_types=1);

namespace App\RendererStrategy;

use App\Contracts\RendererStrategyInterface;
use App\Requests\RenderRequest;
use App\Template;

final readonly class FileRendererStrategy implements RendererStrategyInterface
{
    public function __construct(private RenderRequest $renderRequest)
    {
    }
    public function addRow(Template $template): void
    {
        $row = "├╶╶ {$this->renderRequest->name}.{$this->renderRequest->extension} | " . human_filesize($this->renderRequest->size);
        $template->addRow($row);
    }
}
