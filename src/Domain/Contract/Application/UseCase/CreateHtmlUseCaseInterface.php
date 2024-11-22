<?php

namespace App\Domain\Contract\Application\UseCase;

use App\Application\UseCase\News\CreateHtml\CreateHtmlUseCaseResponse;

interface CreateHtmlUseCaseInterface
{
    public function __invoke(array $request): CreateHtmlUseCaseResponse;
}
