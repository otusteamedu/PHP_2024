<?php

declare(strict_types=1);

namespace Domain\Entities;

class Movie
{
    public ?int $id = null;
    public string $title;
    public string $genre;
}
