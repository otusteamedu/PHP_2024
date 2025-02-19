<?php

namespace App\Application\ReportGenerator;

class NewsDTO
{
    public function __construct(
        public string $title,
        public string $url,
    ) {
    }
}
