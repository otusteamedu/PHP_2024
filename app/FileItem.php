<?php

declare(strict_types=1);

namespace App;

use App\Contracts\FolderItemInterface;
use App\Handlers\AddRowToTemplate;
use App\Handlers\CheckSizeHandler;
use App\Requests\RenderRequest;

final readonly class FileItem implements FolderItemInterface
{

    public function __construct(private RenderRequest $renderRequest)
    {
    }

    public function render(Template $template): void
    {
        $handler = new CheckSizeHandler();

        $handler->setNext(new AddRowToTemplate());

        $handler->handle($this->renderRequest, $template);
    }
}
