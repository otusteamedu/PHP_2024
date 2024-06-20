<?php

declare(strict_types=1);

namespace App\src\RendererStrategy;

use App\src\Contracts\RendererStrategyInterface;
use App\src\Requests\RenderRequest;
use App\src\Template;

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
