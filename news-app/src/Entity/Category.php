<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: NewsCategory::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $newsCategories;

    #[ORM\OneToMany(targetEntity: CategorySubscriber::class, mappedBy: 'category')]
    private Collection $categorySubscribers;

    public function __construct()
    {
        $this->newsCategories = new ArrayCollection();
        $this->categorySubscribers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $newsCategory->setCategory($this);
        }

        return $this;
    }

    public function removeNewsCategory(NewsCategory $newsCategory): static
    {
        if ($this->newsCategories->removeElement($newsCategory)) {
            // set the owning side to null (unless already changed)
            if ($newsCategory->getCategory() === $this) {
                $newsCategory->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CategorySubscriber>
     */
    public function getCategorySubscribers(): Collection
    {
        return $this->categorySubscribers;
    }

    public function addCategorySubscriber(CategorySubscriber $categorySubscriber): static
    {
        if (!$this->categorySubscribers->contains($categorySubscriber)) {
            $this->categorySubscribers->add($categorySubscriber);
            $categorySubscriber->setCategory($this);
        }

        return $this;
    }

    public function removeCategorySubscriber(CategorySubscriber $categorySubscriber): static
    {
        if ($this->categorySubscribers->removeElement($categorySubscriber)) {
            // set the owning side to null (unless already changed)
            if ($categorySubscriber->getCategory() === $this) {
                $categorySubscriber->setCategory(null);
            }
        }

        return $this;
    }
}
