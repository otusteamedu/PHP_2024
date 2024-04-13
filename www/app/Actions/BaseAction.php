<?php

declare(strict_types=1);

namespace Hukimato\App\Actions;

use Hukimato\App\ParamsHandlers\BaseParamsHandler;

abstract class BaseAction
{
    public function __construct(
        /** реальный путь запроса */
        protected readonly string $urlPath,
        /** паттерн соответсвующий запросу */
        protected readonly string $urlPattern,
    )
    {
    }

    protected function getParams(): array
    {
        $requestParams = static::getParamsHandler()->getParams($this->urlPath, $this->urlPattern);
        return $requestParams;
    }

    abstract public function run();

    abstract protected function getParamsHandler(): BaseParamsHandler;
}
