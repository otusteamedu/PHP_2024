<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase;

use Irayu\Hw15\Application\UseCase;

interface DefaultNewsUseCase
{
    public function __invoke(UseCase\Request\DefaultNewsItemRequest $request): UseCase\Response\DefaultNewsItemResponse;
}
