<?php

declare(strict_types=1);

namespace App\Domain\Category;

use App\Domain\DomainInterface\ObservableInterface;
use App\Domain\DomainInterface\ObserverInterface;
use App\Domain\User\User;

class Category implements ObservableInterface, \JsonSerializable
{
    protected ?int $id;

    protected string $title;

    /**
     * @var User[] - array of User IDs
     */
    protected array $subscribers;

    public function getSubscribers(): array
    {
        return $this->subscribers;
    }

    public function setSubscribers(array $subscribers): Category
    {
        $this->subscribers = $subscribers;
        return $this;
    }

    public function __construct(string $title, ?int $id = null, array $subscribers = [])
    {
        $this->id = $id;
        $this->title = $title;
        $this->subscribers = $subscribers;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Category
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Category
    {
        $this->title = $title;
        return $this;
    }

    public function addObserver(ObserverInterface $observer): void
    {
        $this->subscribers[] = $observer;
    }

    public function removeObserver(ObserverInterface $observer): void
    {
        unset($this->subscribers[$observer->getID()]);
    }

    public function notifyObservers(array $data = []): void
    {
        foreach ($this->subscribers as $user) {
            $user->handleNotification($data);
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'title' => $this->getTitle(),
        ];
    }
}
