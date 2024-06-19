<?php

declare(strict_types=1);

namespace App\src\Enums;

use App\src\RendererStrategy\HtmlFileRendererStrategy;
use App\src\RendererStrategy\TxtFileRendererStrategy;

enum TreeItemTypeEnum: string
{
    case TXT = 'txt';
    case HTML = 'html';

    public function getRenderStrategy(): string
    {
        return match ($this) {
            self::HTML => HtmlFileRendererStrategy::class,
            self::TXT => TxtFileRendererStrategy::class,
        };
    }
}
