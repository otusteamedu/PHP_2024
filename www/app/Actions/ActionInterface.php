<?php

declare(strict_types=1);

namespace Hukimato\App\Actions;

use Hukimato\App\ParamsHandlers\ParamsHandlerInterface;

abstract class ActionInterface
{
    abstract public function run();

    abstract protected function getParamsHandler(): ParamsHandlerInterface;
}
