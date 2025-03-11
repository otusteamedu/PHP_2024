<?php

namespace App\Application\UseCase\ReportNews;

class ReportNewsResponse
{
    public function __construct(
        public string $fileUrl
    )
    {
    }

}
