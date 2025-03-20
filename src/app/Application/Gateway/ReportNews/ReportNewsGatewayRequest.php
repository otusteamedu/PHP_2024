<?php

namespace App\Application\Gateway\ReportNews;

use App\Domain\Entity\News;

class ReportNewsGatewayRequest
{
    /**
     * @param News[] $news
     */
    public function __construct(public array $news)
    {
    }
}
