<?php

declare(strict_types=1);

namespace Hukimato\RedisApp\Actions;

use Hukimato\RedisApp\ParamsHandlers\ParamsHandlerInterface;

abstract class ActionInterface
{
    abstract public function run();

    abstract protected function getParamsHandler(): ParamsHandlerInterface;
}
