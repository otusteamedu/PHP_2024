<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Genre;
use App\Domain\ValueObject\TrackDuration;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Track
{
    private int $id;
    private Collection $playlists;

    public function __construct(
        private string $name,
        private string $author,
        private Genre $genre,
        private TrackDuration $duration,
    ) {
        $this->playlists = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

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

    public function getDuration(): TrackDuration
    {
        return $this->duration;
    }

    public function setDuration(TrackDuration $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function setPlaylists(array $playlists): self
    {
        $this->playlists = new ArrayCollection($playlists);

        return $this;
    }

    public function addPlaylist(Playlist $track): self
    {
        $this->playlists->add($track);

        return $this;
    }

    public function removeTrack(Playlist $track): self
    {
        $this->playlists->removeElement($track);

        return $this;
    }
}
