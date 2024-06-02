<?php

declare(strict_types=1);

namespace  AlexanderGladkov\Broker\Web\Component\View;

class View
{
    private string $viewDirectory = VIEW_DIRECTORY;

    public function __construct(private string $path)
    {
    }

    public static function create(string $path): static
    {
        return new static($path);
    }

    public function render($params = []): string
    {
        if (!file_exists($this->getViewFilename())) {
            throw new ViewNotFoundException();
        }

        extract($params);
        ob_start();
        include $this->getViewFilename();
        return (string) ob_get_clean();
    }

    private function getViewFilename(): string
    {
        return $this->viewDirectory . '/' . $this->path . '.php';
    }
}
