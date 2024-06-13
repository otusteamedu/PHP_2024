<?php
declare(strict_types=1);

namespace App\Application\Interface\Observer;

use App\Application\UseCase\Response\Response;

interface SubscriberInterface
{
    public function update(Response $response): void;
}