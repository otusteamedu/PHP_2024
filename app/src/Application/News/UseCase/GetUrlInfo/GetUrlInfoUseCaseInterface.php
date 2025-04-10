<?php

declare(strict_types=1);

namespace Valen\App\Application\News\UseCase\GetUrlInfo;

use Valen\App\Domain\News\Entity\Url;

interface GetUrlInfoUseCaseInterface
{
    public function execute(Url $url): array;
}
