<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\NewsRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?string $content = null;

    #[ORM\OneToMany(targetEntity: NewsCategory::class, mappedBy: 'news', orphanRemoval: true)]
    private Collection $newsCategories;

    public function __construct()
    {
        $this->newsCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, NewsCategory>
     */
    public function getNewsCategories(): Collection
    {
        return $this->newsCategories;
    }

    public function addNewsCategory(NewsCategory $newsCategory): static
    {
        if (!$this->newsCategories->contains($newsCategory)) {
            $this->newsCategories->add($newsCategory);
            $newsCategory->setNews($this);
        }

        return $this;
    }

    public function removeNewsCategory(NewsCategory $newsCategory): static
    {
        if ($this->newsCategories->removeElement($newsCategory)) {
            // set the owning side to null (unless already changed)
            if ($newsCategory->getNews() === $this) {
                $newsCategory->setNews(null);
            }
        }

        return $this;
    }
}
