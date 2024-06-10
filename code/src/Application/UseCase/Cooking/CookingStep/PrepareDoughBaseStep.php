<?php
declare(strict_types=1);

namespace App\Application\UseCase\Cooking\CookingStep;

use App\Application\Interface\Observer\SubscriberInterface;
use App\Application\UseCase\Cooking\FeedbackHandler;
use App\Infrastructure\Observer\Publisher;

class PrepareDoughBaseStep implements SubscriberInterface
{
    public function __construct(
        string $recipe
    ){}

    private function prepare(): void
    {
        echo "Подготовка теста...".PHP_EOL;
        sleep(5);
        $this->repositorySetStatus(2);
        return ;
    }

    public function update(int $status): void
    {
        $publisher = new Publisher();
        $publisher->subscribe(new FeedbackHandler());

    }
}