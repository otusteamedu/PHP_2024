<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusWebserversApp;

class View
{
    /**
     * Метод генерирует страницу
     *
     * @param string $template
     * @param array $data
     *
     * @return void
     */
    public function generatePage(string $template, array $data = []): void
    {
        $path = __DIR__ . '/Resources/Views/' . $template . '.php';

        if (file_exists($path)) {
            require $path;
        }
    }
}
