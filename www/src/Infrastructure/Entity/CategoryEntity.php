<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity;

use App\Domain\Category\Category;
use App\Infrastructure\Repository\CategoryPGRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryPGRepository::class)]
#[ORM\Table(name: 'categories')]
class CategoryEntity
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
    #[ORM\ManyToMany(targetEntity: UserEntity::class, inversedBy: 'categories')]
    protected Collection $subscribers;

    public function __construct(
        string $title,
        ?int   $id = null,
        array  $subscribers = []
    )
    {
        $this->title = $title;
        $this->id = $id;
        $this->subscribers = new ArrayCollection($subscribers);
    }

    public static function getEntityFromDomainModel(Category $category, EntityManagerInterface $em = null): static
    {
        $category = new CategoryEntity(
            $category->getTitle(),
            $category->getId(),
            $category->getSubscribers()
        );

        return $category;
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

    public function getDomainModel(): Category
    {
        /**
         * @var UserEntity[] $users
         */
        $users = $this->getSubscribers()->toArray();

        $users = array_map(fn($user) => $user->getDomainModel(), $users);

        $category = new Category(
            $this->getTitle(),
            $this->getId(),
            $users
        );

        return $category;
    }

}
