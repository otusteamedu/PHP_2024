<?php

declare(strict_types=1);

namespace App\Application\Loader;

interface ContentLoaderInterface
{
    public function load(string $url): ContentLoadResult;
}
