<?php

declare(strict_types=1);

namespace Orlov\Otus\Render;

class ErrorRender implements RenderInterface
{
    public function show(): string //phpcs:ignore
    {
        ob_start();?>
            <p>404 Not Found</p>
        <?

        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}