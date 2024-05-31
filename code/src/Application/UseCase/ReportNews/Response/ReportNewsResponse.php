<?php

namespace App\Application\UseCase\ReportNews\Response;

readonly class ReportNewsResponse
{
    /**
     * @param array $response
     */
    public function __construct(
        public array $response
    ) {}
}