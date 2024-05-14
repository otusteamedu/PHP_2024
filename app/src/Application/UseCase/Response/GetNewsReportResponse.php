<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\Service\UseCaseResponseInterface;

readonly class GetNewsReportResponse implements UseCaseResponseInterface
{
    public function __construct(private string $link)
    {
    }

    public function getData(): mixed
    {
        return $this->link;
    }
}
