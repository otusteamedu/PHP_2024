<?php

declare(strict_types=1);

namespace App\NewsCategory\Domain\Entity;

use App\NewsCategory\Domain\ValueObject\Name;
use App\NewsCategory\Domain\ValueObject\Subscriber;

class Category
{
    public function __construct(
        private readonly int $id,
        private Name $name,
        private array $subscribers
    )
    {

    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function addSubscriber(Subscriber $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function getSubscribers(): array
    {
        return $this->subscribers;
    }
}