<?php

namespace App\Application\Gateway;

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
