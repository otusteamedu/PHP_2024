<?php

namespace App\Application\Gateway;

interface ReportNewsGatewayInterface
{
    public function getReport(ReportNewsGatewayRequest $request): ReportNewsGatewayResponse;

}
