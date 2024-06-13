<?php
declare(strict_types=1);

namespace App\Application\UseCase\Cooking\CookingStep;

use App\Application\Interface\Observer\SubscriberInterface;
use App\Application\UseCase\Cooking\StatusChangeHandler;
use App\Application\UseCase\Response\Response;
use App\Infrastructure\Observer\Publisher;

class PrepareDoughBaseStep implements SubscriberInterface
{

    private int $currentStatus;
    private string $recipe;
    private int $id;
    const STEP = 1;
    public function __construct(
        Response $response
    ){
        $this->recipe = $response->recipe;
        $this->currentStatus = $response->status;
        $this->id = $response->id;
    }
    private function prepare(): int
    {
        if ($this->currentStatus !== self::STEP) return $this->currentStatus;
        echo "Подготовка теста...".PHP_EOL;
        sleep(5);
        return 2;
    }

    public function update(Response $response): void
    {
        $status = $this->prepare();
        $publisher = new Publisher();
        $publisher->subscribe(new StatusChangeHandler());
        $publisher->notify(new Response($status,$this->recipe,$this->id));
    }
}