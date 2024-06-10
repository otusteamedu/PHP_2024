<?php

namespace App\Application\UseCase\Cooking;

use App\Application\Interface\Observer\SubscriberInterface;

class FeedbackHandler implements SubscriberInterface
{

    public function __construct(

    ){}

    public function update(int $status): void
    {
        // TODO: Implement update() method.
    }
}