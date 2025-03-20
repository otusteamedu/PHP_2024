<?php

namespace App\Application\Gateway\ReportNews;

class ReportNewsGatewayResponse
{
    public function __construct(public string $fileUrl)
    {
    }
}
