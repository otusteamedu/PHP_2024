<?php

declare(strict_types=1);

namespace Hukimato\App\ParamsHandlers\Events;

use Hukimato\App\ParamsHandlers\BaseParamsHandler;

class GetParamsHandler extends BaseParamsHandler
{

    public function getParams(string $urlPath, string $urlPattern)
    {
        $data = static::getParamsFromUrlPath($urlPath, $urlPattern);

        return $_GET + $data;
    }
}
