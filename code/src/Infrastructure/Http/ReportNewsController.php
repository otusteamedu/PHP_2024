<?php

namespace App\Infrastructure\Http;

use App\Application\UseCase\ReportNews\ReportNewsUseCase;
use App\Application\UseCase\ReportNews\Request\ReportNewsRequest;
use App\Infrastructure\Repository\PostgreNewsRepository;

class ReportNewsController
{

    const REPORT_FILE = "/data/app/public/report.html";
    private ReportNewsUseCase $reportNewsUseCase;
    private PostgreNewsRepository $repository;
    public function __construct(){
        $this->repository = new PostgreNewsRepository();
        $this->reportNewsUseCase = new ReportNewsUseCase($this->repository);
    }

    public function handle(ReportNewsRequest $request): array|string
    {
        try {
            $res = $this->reportNewsUseCase->getReport($request);
            return $this->writeToFile($res->response);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    private function writeToFile(array $response): false|string
    {
        $str = "<ul>";
        foreach ($response as $news) {
            if ($news[0]['url'] == '') continue;
            $str.= "<li><a href=".$news[0]['url'].">".$news[0]['title']."</a><li>";
        }
        $str.= "</ul>";

        file_put_contents(self::REPORT_FILE,'');
        $putin = file_put_contents(self::REPORT_FILE,iconv('utf-8', 'windows-1251', $str) , FILE_APPEND);
        return $putin? 'http://'.$_SERVER['SERVER_NAME'].'/report.html' : false;

    }

}