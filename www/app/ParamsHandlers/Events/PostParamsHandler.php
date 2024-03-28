<?php

declare(strict_types=1);

namespace Hukimato\RedisApp\ParamsHandlers\Events;

use Hukimato\RedisApp\ParamsHandlers\ParamsHandlerInterface;

class PostParamsHandler implements ParamsHandlerInterface
{

    public function getParams()
    {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);
        return $data;
    }
}
