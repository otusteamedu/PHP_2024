<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Category\Category;
use App\Domain\DomainInterface\ObserverInterface;
use App\Domain\News\News;
use JsonSerializable;

class User implements JsonSerializable, ObserverInterface
{
    protected string $username;
    /**
     * @var News[] Новости о появлении которых надо уведомить пользователя.
     */
    protected array $news;

    /**
     * @var Category[]
     */
    protected array $categories;

    public function __construct(string $username, array $news = [], array $categories = [])
    {
        $this->username = strtolower($username);
        $this->news = $news;
        $this->categories = $categories;
    }

    public function __get(string $name): mixed
    {
        $methodName = 'get' . ucfirst($name);
        return $this->$methodName();
    }

    public function __set(string $name, $value): void
    {
        $methodName = 'set' . ucfirst($name);
        $this->$methodName($value);
    }


    public function getUsername(): string
    {
        return $this->username;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'username' => $this->username,
//            'news' => $this->news,
        ];
    }

    public function handleNotification(array $data = [])
    {
        $this->news[] = $data['news'];
    }

    public function getNews(): array
    {
        return $this->news;
    }

    public function setNews(array $news): User
    {
        $this->news = $news;
        return $this;
    }

    public function clearNews(): User
    {
        $this->news = [];
        return $this;
    }

    public function getID(): string|int
    {
        return $this->username;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }


}
