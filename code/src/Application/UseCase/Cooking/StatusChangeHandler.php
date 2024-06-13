<?php

namespace App\Application\UseCase\Cooking;

use App\Application\Interface\Observer\SubscriberInterface;
use App\Application\UseCase\Response\Response;
use App\Infrastructure\Observer\Publisher;
use App\Infrastructure\Repository\PostgreRepository;

class StatusChangeHandler implements SubscriberInterface
{
    private PostgreRepository $repository;
    private Publisher $publisher;

    public function __construct(){
        $this->repository = new PostgreRepository();
        $this->publisher = new Publisher();
    }

    /**
     * @throws \Exception
     */
    public function update(Response $response): void
    {
        $this->repository->setStatus($response->status, $response->id);

    }

    public function publish(CookingUseCase $cookingUseCase): void
    {
        $this->publisher->subscribe($cookingUseCase);
        $this->publisher->notify();
    }
}