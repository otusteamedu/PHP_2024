<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Category\Category;
use App\Domain\Observer\ObserverInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use ReturnTypeWillChange;

#[ORM\Entity()]
#[ORM\Table(name: 'users')]
class User implements JsonSerializable, ObserverInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    protected string $username;

    #[ORM\Column(type: 'json')]
    protected array $news;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'subscribers')]
    protected Collection $categories;

    public function __construct(string $username, array $news = [], array $categories = [])
    {
        $this->username = $username;
        $this->news = $news;
        $this->categories = new ArrayCollection($categories);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getNews(): array
    {
        return $this->news;
    }

    public function setNews(array $news): void
    {
        $this->news = $news;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function setCategories(Collection $categories): void
    {
        $this->categories = $categories;
    }

    #[ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'username' => $this->username,
//            'news' => $this->news,
        ];
    }

    public function handleNotification(callable $callback): void
    {
        $this->news = $callback($this->news);
    }

    public function getID(): string|int
    {
        return $this->getUsername();
    }
}
