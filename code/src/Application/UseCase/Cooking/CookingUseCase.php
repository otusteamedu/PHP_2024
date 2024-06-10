<?php
declare(strict_types=1);

namespace App\Application\UseCase\Cooking;

use App\Application\Interface\Observer\PublisherInterface;
use App\Application\Interface\Observer\SubscriberInterface;
use App\Application\UseCase\Response\Response;

class CookingUseCase implements SubscriberInterface
{


    private $publisher;

    public function __construct(
        PublisherInterface $publisher
    ){}

    public function __invoke(Response $response): void
    {
        $this->publisher->notify($response->status);
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    private function handle(ObserverUpdater $updater)
    {

    }
}