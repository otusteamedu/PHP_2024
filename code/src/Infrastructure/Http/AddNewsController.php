<?php
declare(strict_types=1);
namespace App\Infrastructure\Http;

use App\Application\UseCase\AddNews\AddNewsUseCase;
use App\Application\UseCase\AddNews\Request\AddNewsRequest;
use App\Infrastructure\Repository\PostgreNewsRepository;


class AddNewsController
{
    private AddNewsUseCase $addNewsUseCase;
    private PostgreNewsRepository $repository;
    public function __construct(){
        $this->repository = new PostgreNewsRepository(
            getenv("POSTGRES_HOST"),
            getenv("POSTGRES_DATABASE"),
            getenv("POSTGRES_USER"),
            getenv("POSTGRES_PASSWORD")
        );
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