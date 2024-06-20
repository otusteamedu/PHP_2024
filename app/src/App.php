<?php

declare(strict_types=1);

namespace App\src;

use App\src\Composite\CompositeTree;
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
        $composite = new CompositeTree();

        return $composite->buildTree($this->startPath, $this->dirExceptions);
    }
}
