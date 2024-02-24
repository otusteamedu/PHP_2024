<?php

namespace Pavelsergeevich\Hw6\Core;

use Pavelsergeevich\Hw6\Config\Config;

class View
{
    public string $pagePath;
    public string $layout = 'default';
    public string $defaultTitle;
    public string $title;
    public array $pageParams;
    public string $pageContent;
    public string $layoutPath;

    /**
     * @throws \Exception
     */
    public function __construct($routeParams)
    {
        $this->layoutPath = Config::LAYOUTS_DIR . '/' . mb_strtolower($this->layout) . '.php';
        $this->pagePath = Config::PAGES_DIR . '/'  . mb_strtolower($routeParams['controller'] . '/' . $routeParams['action']) . '.php';
        $this->defaultTitle = $routeParams['controller'] . ' > ' . $routeParams['action'];
    }

    /**
     * @param array|null $pageParams
     * @param string|null $title
     * @throws \Exception
     */
    public function render(?array $pageParams = [], ?string $title = null)
    {
        $this->title = $title ?? $this->defaultTitle;
        $this->pageParams = $pageParams;

        if (!file_exists($this->pagePath)) {
            throw new \Exception('Не обнаружен файл страницы: ' . $this->pagePath);
        }
        ob_start();
        require $this->pagePath;
        $this->pageContent = ob_get_clean();

        if (!file_exists($this->layoutPath)) {
            throw new \Exception('Не обнаружен шаблон сайта: ' . $this->layoutPath);
        }
        require $this->layoutPath;
    }

    public static function errorCode(\Throwable $exception)
    {
        $errorCode = $exception->getCode();
        $errorPagePath = Config::PAGES_DIR . '/errors/'  . $errorCode . '.php';
        if ($errorCode && file_exists($errorPagePath)) {
            http_response_code($errorCode);
            require $errorPagePath;
        } else {
            http_response_code(500);
            require Config::PAGES_DIR . '/errors/500.php';
        }
    }

}