<?php

declare(strict_types=1);

namespace App\Domain\Category;

use App\Domain\Observer\ObservableInterface;
use App\Domain\Observer\ObserverInterface;
use App\Domain\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity()]
#[ORM\Table(name: 'categories')]
class Category implements ObservableInterface, JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id;

    #[ORM\Column(type: 'string', unique: true)]
    private string $title;

    #[ORM\JoinTable(name: 'subscribers')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'subscriber_username', referencedColumnName: 'username')]
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'categories')]
    protected Collection $subscribers;


    public function __construct(
        string $title,
        ?int $id = null,
        array $subscribers = []
    ) {
        $this->title = $title;
        $this->id = $id;
        $this->subscribers = new ArrayCollection($subscribers);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getSubscribers(): Collection
    {
        return $this->subscribers;
    }

    public function setSubscribers(Collection $subscribers): void
    {
        $this->subscribers = $subscribers;
    }

    public function addObserver(ObserverInterface $observer): void
    {
        $this->getSubscribers()->add($observer);
    }

    public function removeObserver(ObserverInterface $observer): void
    {
        $this->getSubscribers()->removeElement($observer);
    }

    public function notifyObservers(callable $callback): void
    {
        foreach ($this->subscribers as $user) {
            $user->handleNotification($callback);
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'title' => $this->getTitle(),
        ];
    }
}
