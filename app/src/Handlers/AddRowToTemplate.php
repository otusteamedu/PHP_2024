<?php

declare(strict_types=1);

namespace App\src\Handlers;

use App\src\Enums\TreeItemTypeEnum;
use App\src\RendererStrategy\DirRendererStrategy;
use App\src\RendererStrategy\FileRendererStrategy;
use App\src\Requests\RenderRequest;
use App\src\Template;

class AddRowToTemplate extends RenderHandler
{
    public function handle(RenderRequest $renderRequest, Template $template): void
    {
        $strategy = new DirRendererStrategy($renderRequest);

        if (!is_dir($renderRequest->path)) {
            $strategy = match (TreeItemTypeEnum::tryFrom($renderRequest->extension)) {
                null => new FileRendererStrategy($renderRequest),
                default => new (TreeItemTypeEnum::tryFrom($renderRequest->extension)->getRenderStrategy())(
                    $renderRequest
                )
            };
        }

        $strategy->addRow($template);

        parent::handle($renderRequest, $template);
    }
}
