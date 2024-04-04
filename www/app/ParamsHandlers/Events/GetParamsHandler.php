<?php

declare(strict_types=1);

namespace Hukimato\App\ParamsHandlers\Events;

use Hukimato\App\ParamsHandlers\ParamsHandlerInterface;

class GetParamsHandler implements ParamsHandlerInterface
{

    public function getParams()
    {
        return $_GET;
    }
}
