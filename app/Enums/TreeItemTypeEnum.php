<?php

declare(strict_types=1);

namespace App\Enums;

use App\RendererStrategy\HtmlFileRendererStrategy;
use App\RendererStrategy\TxtFileRendererStrategy;

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
