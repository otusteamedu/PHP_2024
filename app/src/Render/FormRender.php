<?php

declare(strict_types=1);

namespace Orlov\Otus\Render;

class FormRender implements RenderInterface
{
    public function show(): string //phpcs:ignore
    {
        ob_start();
        ?>
          <form method="post" action="/formHandler">
            <p>Генерация банковской выписки за указанные даты:</p>
            От <input required type="date" name="date_from" value="<?php echo date('Y-m-d'); ?>">
            По <input type="date" name="date_to" value="<?php echo date('Y-m-d'); ?>">
            <p><input type="submit" name="send" value="Запросить"></p>
          </form>
        <?

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}