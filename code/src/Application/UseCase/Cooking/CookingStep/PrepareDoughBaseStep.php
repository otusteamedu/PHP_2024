<?php
declare(strict_types=1);

namespace App\Application\UseCase\Cooking\CookingStep;

use App\Application\Interface\Observer\SubscriberInterface;
use App\Application\UseCase\Cooking\StatusChangeHandler;
use App\Application\UseCase\Response\Response;

class PrepareDoughBaseStep implements SubscriberInterface
{

    private StatusChangeHandler $statusHandler;
    private const STEP = 1;

    public function __construct(
        StatusChangeHandler $statusChangeHandler
    ){
        $this->statusHandler = $statusChangeHandler;
    }
    private function prepare(): int
    {
        echo "Подготовка теста...".PHP_EOL;
        sleep(1);
        return 2;
    }


    /**
     * @throws \Exception
     */
    public function update(Response $response): void
    {
        if ($this->statusHandler->status === self::STEP) {
            $status = $this->prepare();
            $this->statusHandler->nextStep($status);
        }
    }
}