<?php

declare(strict_types=1);

namespace Afilipov\Hw13;

use Closure;

class Movie
{
    private Closure $reviewReference;

    private ?array $reviews = null;

    public function __construct(
        #[DBField('id')] private int $id,
        #[DBField('title')] private $title,
        #[DBField('director')] private string $director,
        #[DBField('release_year')] private int $releaseYear
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDirector(): string
    {
        return $this->director;
    }

    public function setLastName(string $director): self
    {
        $this->director = $director;

        return $this;
    }

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): self
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }


    public function setReviewReference(Closure $reviewReference): void
    {
        $this->reviewReference = $reviewReference;
    }

    /**
     * @return array<Review>
     */
    public function getReviews(): array
    {
        if ($this->reviews === null) {
            $this->reviews = ($this->reviewReference)();
        }
        return $this->reviews;
    }
}
