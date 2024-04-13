<?php

declare(strict_types=1);

namespace Hukimato\App\Routers;

class ActionDTO
{
    public function __construct(
        public readonly string $actionClass,
        public readonly string $urlPattern,
        public readonly string $urlPath,
    )
    {

    }
}
