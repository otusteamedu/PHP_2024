<?php
declare(strict_types=1);
namespace App\Infrastructure\Routes\Http;

use App\Application\UseCase\AddNews\AddNewsUseCase;
use App\Application\UseCase\AddNews\Request\AddNewsRequest;
use App\Infrastructure\Repository\PostgreRepository;


class AddNewsController
{
    private AddNewsUseCase $addNewsUseCase;
    private PostgreRepository $repository;
    public function __construct(){
        $this->repository = new PostgreRepository();
        $this->addNewsUseCase = new AddNewsUseCase($this->repository);
    }

    public function handle(AddNewsRequest $request): int | string
    {
        try {
            $response = $this->addNewsUseCase->add($request);
            return $response->id;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

}