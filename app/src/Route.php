<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusWebserversApp;

use SlavaMakhov\OtusWebserversApp\Http\Requests\Request;

class Route
{
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Метод распределяет роуты
     *
     * @return void
     */
    public function start(): void
    {
        if (!empty($this->routes)) {
            $routes = $this->routes;

            $checkRoute = $routes[$this->getCurrentUrl()] ?? [];

            if (!empty($checkRoute)) {
                $controller = $checkRoute[0];
                $method = $checkRoute[1];
                $class = new $controller();
                $class->$method($this->request);
                return;
            }
        }

        $this->renderPage404();
    }

    /**
     * Метод получает текущий урл пользователя
     *
     * @return string
     */
    private function getCurrentUrl(): string
    {
        $path = $this->request->path;
        $position = strpos($path, '?');

        return $position !== false ? substr($path, 0, $position) : $path;
    }

    /**
     * Метод вызывает страницу 404 ошибки
     *
     * @return void
     */
    private function renderPage404(): void
    {
        (new View())->generatePage('404');
    }
}
