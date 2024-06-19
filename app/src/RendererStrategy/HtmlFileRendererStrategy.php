<?php

declare(strict_types=1);

namespace App\src\RendererStrategy;

use App\src\Contracts\RendererStrategyInterface;
use App\src\Requests\RenderRequest;
use App\src\Template;

final readonly class HtmlFileRendererStrategy implements RendererStrategyInterface
{
    public function __construct(private RenderRequest $renderRequest, private int $maxShowContentLength = 50)
    {
    }

    public function addRow(Template $template): void
    {
        $content = file_get_contents($this->renderRequest->path) ?? '';

        $shortContent = substr(
            trim(strip_tags(preg_replace('/\s\s+/', '', $content))),
            0,
            $this->maxShowContentLength
        );

        $size = human_filesize($this->renderRequest->size);
        $row = "├╶╶ {$this->renderRequest->name}.{$this->renderRequest->extension} | $size | $shortContent";

        if (strlen($content) > $this->maxShowContentLength) {
            $row .= '...';
        }

        $template->addRow($row);
    }
}
