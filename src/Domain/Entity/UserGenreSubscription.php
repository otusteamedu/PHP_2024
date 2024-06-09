<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Genre;

// ToDo: Сделать через кастомные типы, потому что тут они являются id.
class UserGenreSubscription
{
    public function __construct(
        private Email $userEmail,
        private Genre $genre,
    ) {
    }

    public function getUserEmail(): Email
    {
        return $this->userEmail;
    }

    public function setUserEmail(Email $userEmail): self
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getGenre(): Genre
    {
        return $this->genre;
    }

    public function setGenre(Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }
}
