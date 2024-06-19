<?php

declare(strict_types=1);

namespace App\src;

use App\src\Contracts\FolderItemInterface;
use App\src\Handlers\AddRowToTemplate;
use App\src\Handlers\CheckSizeHandler;
use App\src\Requests\RenderRequest;

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
