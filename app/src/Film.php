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

    private $changedFields = [];

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
        return $this->compareValue('name', $name);
    }

    public function getOriginalName()
    {
        return $this->original_name;
    }

    public function setOriginalName($original_name): self
    {
        return $this->compareValue('original_name', $original_name);
    }

    public function getReleaseDate()
    {
        return $this->release_date;
    }

    public function setReleaseDate($release_date): self
    {
        return $this->compareValue('release_date', $release_date);
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating): self
    {
        return $this->compareValue('rating', $rating);
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration): self
    {
        return $this->compareValue('duration', $duration);
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        return $this->compareValue('description', $description);
    }

    private function compareValue($field, $newValue)
    {
        $oldValue = $this->$field;
        if ($oldValue <> $newValue) {
            $this->changedFields[$field] = $newValue;
            $this->$field = $newValue;
        }
        return $this;
    }

    public function getChangedFields()
    {
        return $this->changedFields;
    }
}
