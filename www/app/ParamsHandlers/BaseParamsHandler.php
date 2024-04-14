<?php

declare(strict_types=1);

namespace Hukimato\App\ParamsHandlers;

abstract class BaseParamsHandler
{
    abstract public function getParams(string $urlPath, string $urlPattern);

    protected function getParamsFromUrlPath($urlPath, $urlPattern)
    {
        preg_match($urlPattern, $urlPath, $data);

        return array_filter($data, function ($key) {
            return !is_int($key);
        }, ARRAY_FILTER_USE_KEY);
    }
}
