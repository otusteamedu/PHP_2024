<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\Gateway;

interface UrlLoaderInterface
{
    public function getContent(UrlLoaderRequest $request): UrlLoaderResponse;
}
