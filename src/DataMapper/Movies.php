<?php

declare(strict_types=1);

namespace hw17\DataMapper;

class Movies
{
    public function __construct(
        private int $id,
        private string $title,
        private string $description,
        private string $ageLimit,
        private string $language,
        private string $genre,
        private string $country,
        private int $premiereDate,
        private int $movieDuration
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getAgeLimit(): string
    {
        return $this->ageLimit;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return int
     */
    public function getMovieDuration(): int
    {
        return $this->movieDuration;
    }

    /**
     * @return int
     */
    public function getPremiereDate(): int
    {
        return $this->premiereDate;
    }

    /**
     * @param string $ageLimit
     */
    public function setAgeLimit(string $ageLimit): self
    {
        $this->ageLimit = $ageLimit;

        return $this;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $genre
     */
    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @param int $movieDuration
     */
    public function setMovieDuration(int $movieDuration): self
    {
        $this->movieDuration = $movieDuration;

        return $this;
    }

    /**
     * @param int $premiereDate
     */
    public function setPremiereDate(int $premiereDate): self
    {
        $this->premiereDate = $premiereDate;

        return $this;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
