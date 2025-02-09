<?php

declare(strict_types=1);

namespace Domain\Entities;

class Show
{
    public int $id;
    public int $movie_id;
    public int $theatre_id;
    public \DateTimeInterface $start;
}
