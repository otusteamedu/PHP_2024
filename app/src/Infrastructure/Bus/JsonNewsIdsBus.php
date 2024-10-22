<?php

namespace App\Infrastructure\Bus;

use App\Application\Bus\Dto\NewsItemsIdsBusRequestDto;
use App\Application\Bus\Dto\NewsItemsIdsBusResponseDto;
use App\Application\Bus\NewsItemsIdsBusInterface;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class JsonNewsIdsBus implements NewsItemsIdsBusInterface
{
    public function getNewsIds(NewsItemsIdsBusRequestDto $requestDto): NewsItemsIdsBusResponseDto
    {
        $jsonDecoder = new JsonDecode();
        $arIds = $jsonDecoder->decode($requestDto->jsonIds, JsonEncoder::FORMAT);

        return new NewsItemsIdsBusResponseDto($arIds);
    }
}
