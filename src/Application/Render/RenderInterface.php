<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\Render;

interface RenderInterface
{
    public function render(string $path): void;
}
