<?php

declare(strict_types=1);

namespace App\src\Composite;

use App\src\Requests\PathRequest;
use App\src\Template;
use Exception;

class CompositeTree
{
    /**
     * @throws Exception
     */
    public function buildTree(string $startPath, array $dirExceptions = []): string
    {
        $dir = scandir($startPath);

        if (!$dir) {
            throw new Exception('Directory not found');
        }

        $template = new Template();
        $startFolder = new FolderItem(
            new PathRequest($startPath),
            $dirExceptions
        );
        $startFolder->build();
        $startFolder->render($template);

        return $template() . PHP_EOL;
    }
}