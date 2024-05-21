<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;

class Playlist
{
    private int $id;

    public function __construct(
        private Email $userEmail,
        private string $name,
        private iterable $tracks = [],
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): Email
    {
        return $this->userEmail;
    }

    public function setUser(Email $userEmail): self
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTracks(): array
    {
        return $this->tracks;
    }

    public function setTracks(array $tracks): self
    {
        $this->tracks = $tracks;

        return $this;
    }

    public static function createEmptyPlaylist(string $user, string $name): self
    {
        return new self(new Email($user), $name);
    }
}
