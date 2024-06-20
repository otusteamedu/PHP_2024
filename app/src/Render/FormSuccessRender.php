<?php

declare(strict_types=1);

namespace Orlov\Otus\Render;

class FormSuccessRender implements RenderInterface
{
    public function show(): string
    {
        ob_start();
        ?>
          <p>Ваша заявка принята. Ожидайте отчёт на электронную почту</p>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
