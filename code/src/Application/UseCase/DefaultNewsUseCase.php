<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase;

use Irayu\Hw15\Application\UseCase\Request\AddNewsItemRequest;
use Irayu\Hw15\Application\UseCase\Response\AddNewsItemResponse;

use Irayu\Hw15\Domain;

interface DefaultNewsUseCase
{
   public function __invoke(DefaultNewsItemRequest $request): DefaultNewsItemResponse;
}