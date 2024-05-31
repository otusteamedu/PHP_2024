<?php

namespace App\Infrastructure\Http;

use App\Application\UseCase\ListNews\ListNewsUseCase;
use App\Application\UseCase\ListNews\Response\ListNewsResponse;
use App\Infrastructure\Repository\PostgreNewsRepository;

class ListNewsController
{
    private ListNewsUseCase $listNewsUseCase;
    private PostgreNewsRepository $repository;
    public function __construct(){
        $this->repository = new PostgreNewsRepository();
        $this->listNewsUseCase = new ListNewsUseCase($this->repository);
    }

    public function handle(): array|string
    {
        try {
            $res = $this->listNewsUseCase->getList();
            return $res->response;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}