<?php
declare(strict_types=1);

namespace App\Application\Interface\Observer;

use App\Application\UseCase\Cooking\StatusChangeHandler;
use App\Application\UseCase\Response\Response;

interface PublisherInterface
{
    public function subscribe(SubscriberInterface $subscriber): void;
    public function unsubscribe(SubscriberInterface $subscriber): void;
    public function notify(Response $response): void;
}