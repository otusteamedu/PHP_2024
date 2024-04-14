<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Domain\Entity;

use RailMukhametshin\Hw\Domain\ValueObject\Rating;

class Order
{
    private int $id;
    private Rating $rating;

    public function __construct(int $id, Rating $rating)
    {
        $this->id = $id;
        $this->rating = $rating;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRating(): Rating
    {
        return $this->rating;
    }

    public function setRating(Rating $rating): self
    {
        $this->rating = $rating;
        return  $this;
    }
}