<?php

namespace App\Application\UseCase\ListNews\Response;

readonly class ListNewsResponse
{
    public function __construct(
        public array $response
    ) {}

}