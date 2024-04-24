<?php

declare(strict_types=1);

namespace Rmulyukov\Hw;

use InvalidArgumentException;
use Rmulyukov\Hw\Factory\AbstractFileSystemItemFactory;

final readonly class App
{
    public function __construct(
        private AbstractFileSystemItemFactory $factory
    ) {
    }

    public function run(string $path): string
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException('Dir not found');
        }

        $tree = $this->factory->createTree($path);
        return $tree->convertToTree();
    }
}
