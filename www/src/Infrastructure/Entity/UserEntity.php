<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity;

use App\Domain\User\User;
use App\Infrastructure\Repository\UserPGRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: UserPGRepository::class)]
#[ORM\Table(name: 'users')]
class UserEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    private string $username;

    #[ORM\Column(type: 'json')]
    private array $news;

    #[ORM\ManyToMany(targetEntity: CategoryEntity::class, mappedBy: 'subscribers')]
    private Collection $categories;

    public function __construct(string $username, array $news, array $categories = [])
    {
        $this->username = $username;
        $this->news = $news;
        $this->categories = new ArrayCollection($categories);
    }

    public static function getEntityFromDomainModel(User $user, EntityManagerInterface $em = null): static
    {
        return new UserEntity(
            $user->getUsername(),
            $user->getNews(),
            $user->getCategories()
        );
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

    public function getDomainModel(): User
    {


        $user = new User(
            $this->getUsername(),
            $this->getNews(),
            $this->getCategories()->toArray()
        );
        return $user;
    }
}