<?php

declare(strict_types=1);

namespace App\src;

use App\FolderItem;
use App\Requests\PathRequest;
use App\Template;
use Exception;

readonly class App
{

    public function __construct(private string $startPath, private array $dirExceptions = [])
    {
    }

    /**
     * @throws Exception
     */
    public function run(): string
    {
        return $this->buildTree();
    }

    /**
     * @throws Exception
     */
    private function buildTree(): string
    {
        $dir = scandir($this->startPath);

        if (!$dir) {
            throw new Exception('Directory not found');
        }

        $template = new Template();
        $startFolder = new FolderItem(
            new PathRequest($this->startPath),
            $this->dirExceptions
        );
        $startFolder->build();
        $startFolder->render($template);

        return $template() . PHP_EOL;
    }
}
