<?php

declare(strict_types=1);

namespace Hukimato\App\ParamsHandlers\Events;

use Hukimato\App\ParamsHandlers\BaseParamsHandler;

class PostParamsHandler extends BaseParamsHandler
{

    public function getParams(string $urlPath, string $urlPattern)
    {
        $data = static::getParamsFromUrlPath($urlPath, $urlPattern);

        $postData = file_get_contents('php://input');
        $data['body'] = json_decode($postData, true);
        return $data;
    }
}
