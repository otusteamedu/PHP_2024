<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Collection\TracksCollection;
use App\Domain\ValueObject\Email;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Playlist
{
    private int $id;
    private Collection $tracks;

    public function __construct(
        private Email $userEmail,
        private string $name,
    ) {
        $this->tracks = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    public function setTrackCollection(TracksCollection $tracks): self
    {
        $this->tracks = new ArrayCollection($tracks->toArray());

        return $this;
    }

    public function addTrack(Track $track): self
    {
        $this->tracks->add($track);

        return $this;
    }

    public function removeTrack(Track $track): self
    {
        $this->tracks->removeElement($track);

        return $this;
    }
}
