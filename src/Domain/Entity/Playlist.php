<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Collection\TracksCollection;
use App\Domain\ValueObject\Email;

class Playlist
{
    private int $id;
    private iterable $tracks;

    public function __construct(
        private Email $userEmail,
        private string $name,
    ) {
        $this->tracks = new TracksCollection();
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

    public function getTracks(): TracksCollection
    {
        return $this->tracks;
    }

    public function setTrackCollection(array $tracks): self
    {
        $this->tracks = new TracksCollection($tracks);

        return $this;
    }

    public function addTrack(Track $track): self
    {
        $this->tracks->add($track);

        return $this;
    }

    public function removeTrack(Track $track): self
    {
        $this->tracks->remove($track);

        return $this;
    }

    public static function createEmptyPlaylist(string $user, string $name, array $tracks): self
    {
        return (new self(new Email($user), $name))
            ->setTrackCollection($tracks);
    }
}
