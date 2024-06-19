<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Enums\TreeItemTypeEnum;
use App\RendererStrategy\DirRendererStrategy;
use App\RendererStrategy\FileRendererStrategy;
use App\Requests\RenderRequest;
use App\Template;

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
