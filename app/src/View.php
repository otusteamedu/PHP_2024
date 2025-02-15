<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusQueueApp;

class View
{
    /**
     * Метод генерирует страницу
     *
     * @param string $template
     *
     * @return void
     */
    public function generatePage(string $template): void
    {
        $path = __DIR__ . '/Resources/Views/' . $template . '.php';

        if (file_exists($path)) {
            require $path;
        }
    }
}
