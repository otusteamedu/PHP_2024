<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Render;

use Alogachev\Homework\Application\Render\RenderInterface;

class HtmlRenderManager implements RenderInterface
{
    public function __construct(
        private readonly string $templatesPath,
    ) {
    }

    public function render(string $path): void
    {
        require $this->templatesPath . $path ;
    }
}
