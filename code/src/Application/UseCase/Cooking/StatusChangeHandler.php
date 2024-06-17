<?php

namespace App\Application\UseCase\Cooking;

use App\Application\Interface\Observer\PublisherInterface;
use App\Application\Interface\Observer\SubscriberInterface;
use App\Application\UseCase\Response\Response;
use App\Infrastructure\Builder\RecipeBuilder;
use App\Infrastructure\Observer\Publisher;
use App\Infrastructure\Repository\PostgreRepository;
use Exception;
use Random\RandomException;
use RuntimeException;

class StatusChangeHandler
{
    private PostgreRepository $repository;
    public Publisher $publisher;
    public int $status;
    private int $id;
    private string $recipe;


    public function __construct(
        Response $response
    ){
        $this->repository = new PostgreRepository();
        $this->publisher = new Publisher();
        $this->status = $response->status;
        $this->id = $response->id;
        $this->recipe = $response->recipe;
    }

    /**
     * @throws RuntimeException|RandomException
     * @throws Exception
     */
    public function nextStep(int $status): void
    {
        $this->repository->setStatus($status, $this->id);
        $this->status = $status;

        # Рандомное событие, при котором заказ испорчен
        $fail = random_int(0,10);
        if ($fail === 5) {
            $this->repository->delete($this->id);
            throw new RuntimeException("Приготовление прервано.");
        }

        $this->publisher->notify(new Response($status, $this->recipe, $this->id));
    }


}