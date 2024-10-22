<?php

declare(strict_types=1);

namespace App\Application\Bus;

use App\Application\Bus\Dto\NewsItemUrlBusRequestDto;
use App\Application\Bus\Dto\NewsItemUrlBusResponseDto;

interface NewsItemUrlBusInterface
{
    public function getNewsItemByUrl(NewsItemUrlBusRequestDto $requestDto): NewsItemUrlBusResponseDto;
}
