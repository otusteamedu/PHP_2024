<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity;

use App\Domain\News\News;
use App\Domain\State\AbstractState;
use App\Infrastructure\Repository\NewsPGRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsPGRepository::class)]
#[ORM\Table(name: 'news')]
class NewsEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected ?int $id;

    #[ORM\Column(type: 'string', unique: true)]
    protected string $title;

    #[ORM\Column(type: 'datetime')]
    protected DateTime $createdAt;

    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(name: 'author_username', referencedColumnName: 'username')]
    protected UserEntity $author;

    #[ORM\ManyToOne(targetEntity: CategoryEntity::class)]
    protected CategoryEntity $category;

    #[ORM\Column(type: 'string')]
    protected ?string $body;

    #[ORM\Column(type: 'integer')]
    protected int $state;

    public function __construct(
        ?int           $id,
        string         $title,
        UserEntity     $author,
        DateTime       $createdAt,
        CategoryEntity $category,
        string         $body,
        int            $state = 0
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->createdAt = $createdAt;
        $this->category = $category;
        $this->body = $body;
        $this->state = $state;
    }

    public static function getEntityFromDomainModel(News $news, EntityManagerInterface $em = null): static
    {
        $news = new NewsEntity(
            $news->getId(),
            $news->getTitle(),
            UserEntity::getEntityFromDomainModel($news->getAuthor()),
            $news->getCreatedAt(),
            CategoryEntity::getEntityFromDomainModel($news->getCategory()),
            $news->getBody(),
            AbstractState::getScalarFromState($news->getState())
        );

        if ($em) {
            $news->setCategory(
                $em->getRepository(CategoryEntity::class)->find($news->getCategory()->getId())
            );
            $news->setAuthor(
                $em->getRepository(UserEntity::class)->find($news->getAuthor()->getUsername())
            );
        }

        return $news;
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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getAuthor(): UserEntity
    {
        return $this->author;
    }

    public function setAuthor(UserEntity $author): void
    {
        $this->author = $author;
    }

    public function getCategory(): CategoryEntity
    {
        return $this->category;
    }

    public function setCategory(CategoryEntity $category): void
    {
        $this->category = $category;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): void
    {
        $this->body = $body;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function setState(int $state): void
    {
        $this->state = $state;
    }

    public function getStateModel(): AbstractState
    {
        return AbstractState::getStateFromScalar($this->state);
    }

    public function getDomainModel(): News
    {
        $news = new News(
            $this->getId(),
            $this->getTitle(),
            $this->getAuthor()->getDomainModel(),
            $this->getCreatedAt(),
            $this->getCategory()->getDomainModel(),
            $this->getBody(),
            $this->getStateModel(),
        );
        return $news;
    }
}
