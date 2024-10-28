<?php

namespace App\Application\UseCase\News\GetNewsListByIdArray;

class GetNewsListByIdUseCaseRequest
{
    /**
     * @param int[] $idArray
     */
    public function __construct(
        public readonly array $idArray,
    ) {
    }
}
