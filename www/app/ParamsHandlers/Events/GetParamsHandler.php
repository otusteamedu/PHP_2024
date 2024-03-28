<?php

declare(strict_types=1);

namespace Hukimato\RedisApp\ParamsHandlers\Events;

use Hukimato\RedisApp\ParamsHandlers\ParamsHandlerInterface;

class GetParamsHandler implements ParamsHandlerInterface
{

    public function getParams()
    {
        return $_GET;
    }
}
