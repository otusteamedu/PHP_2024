<?php

namespace App\Infrastructure\Http;

use App\Application\UseCase\ReportNews\ReportNewsUseCase;
use App\Infrastructure\Repository\PostgreNewsRepository;

class ReportNewsController
{

    private ReportNewsUseCase $reportNewsUseCase;
    private PostgreNewsRepository $repository;
    public function __construct(){
        $this->repository = new PostgreNewsRepository();
        $this->reportNewsUseCase = new ReportNewsUseCase($this->repository);
    }

    public function handle(): array|string
    {
        try {
            $res = $this->reportNewsUseCase->getReport();
            return $res->response;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}