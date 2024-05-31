<?php

namespace App\Application\UseCase\ReportNews\Request;

readonly class ReportNewsRequest
{
    public function __construct(
        public array $request
    )
    {}

}