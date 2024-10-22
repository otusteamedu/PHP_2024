<?php

namespace App\Application\Bus;

use App\Application\Bus\Dto\NewsItemsIdsBusRequestDto;
use App\Application\Bus\Dto\NewsItemsIdsBusResponseDto;

interface NewsItemsIdsBusInterface
{
    public function getNewsIds(NewsItemsIdsBusRequestDto $requestDto): NewsItemsIdsBusResponseDto;
}
