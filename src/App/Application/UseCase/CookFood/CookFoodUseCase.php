<?php

namespace App\Application\UseCase\CookFood;

use App\Application\ChainOfResponsibility\CookingProcessRequest;
use App\Application\ChainOfResponsibility\Middleware;
use App\Application\Composite\FoodCompositeInterface;
use App\Application\Composite\FoodCompositeRequest;
use App\Application\Observer\PublisherInterface;
use App\Domain\Enum\Status;
use App\Infrastructure\ChainOfResponsibility\CookingMenuFoodHandler;
use App\Infrastructure\ChainOfResponsibility\CookingStandardHandler;

class CookFoodUseCase
{
    public function __construct(private FoodCompositeInterface $foodCompositeGateway, private PublisherInterface $publisher)
    {
    }

    public function __invoke(CookFoodRequest $request)
    {
        //Компоновщик
        $foodCompositeRequest = new FoodCompositeRequest($request->foodComposite, $request->foodAdditives);
        $foodCompositeResponse = $this->foodCompositeGateway->composite($foodCompositeRequest);

        $cookingProcessRequest = new CookingProcessRequest($foodCompositeResponse->foodComposite, Status::START, $request->foodAdditives, $this->publisher);

        //Цепочка обязанностей
        $processHandler = new CookingStandardHandler();
        $processHandler->setNext(new CookingMenuFoodHandler());

        $middleware = new Middleware($processHandler);
        $middleware->process($cookingProcessRequest);
    }
}