<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Render;

use Alogachev\Homework\Application\Render\RenderInterface;

class HtmlRenderManager implements RenderInterface
{
    public function render(string $path): void
    {
        echo dirname(__DIR__) . '/' . $path;
    }
}
