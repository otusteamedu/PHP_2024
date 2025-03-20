<?php

namespace App\Infrastructure\Gateway;

use App\Application\Gateway\ReportNews\ReportNewsGatewayInterface;
use App\Application\Gateway\ReportNews\ReportNewsGatewayRequest;
use App\Application\Gateway\ReportNews\ReportNewsGatewayResponse;
use Illuminate\Support\Facades\Storage;

class ReportNewsGateway implements ReportNewsGatewayInterface
{
    public function getReport(ReportNewsGatewayRequest $request): ReportNewsGatewayResponse
    {
        $view = view('report', ['newsList' => $request->news]);
        $render = $view->render();

        $filename = 'news_list_' . now()->timestamp . '.html';

        Storage::disk('public')->append($filename, $render);
        $path = Storage::disk('public')->url($filename);

        return new ReportNewsGatewayResponse($path);
    }
}
