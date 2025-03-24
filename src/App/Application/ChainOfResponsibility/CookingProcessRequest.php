<?php

namespace App\Application\ChainOfResponsibility;

use App\Application\Observer\PublisherInterface;
use App\Domain\Entity\FoodComposite;
use App\Domain\Enum\Status;
use App\Infrastructure\Observer\StatusEvent;

class CookingProcessRequest
{
    public function __construct(public FoodComposite $foodComposite, private Status $status, public array $foodAdditives, private PublisherInterface $publisherInterface)
    {
    }


    public function setStatus(Status $status): void
    {
        $this->status = $status;

        $this->publisherInterface->notify(new StatusEvent($this->status));
    }

    public function getStatus(): Status
    {
        return $this->status;
    }
}