<?php

namespace App\Application\Gateway\ReportNews;

interface ReportNewsGatewayInterface
{
    public function getReport(ReportNewsGatewayRequest $request): ReportNewsGatewayResponse;

}
