<?php

declare(strict_types=1);

namespace Evgenyart\Hw13;

use Exception;

class Film
{
    private $id;

    private $name;

    private $original_name;

    private $release_date;

    private $rating;

    private $duration;

    private $description;

    public function __construct($id, $name, $original_name, $release_date, $rating, $duration, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->original_name = $original_name;
        $this->release_date = $release_date;
        $this->rating = $rating;
        $this->duration = $duration;
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOriginalName()
    {
        return $this->original_name;
    }

    public function setOriginalName($original_name): self
    {
        $this->original_name = $original_name;

        return $this;
    }

    public function getReleaseDate()
    {
        return $this->release_date;
    }

    public function setReleaseDate($release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }
}
