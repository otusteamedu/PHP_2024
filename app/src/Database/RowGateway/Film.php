<?php

declare(strict_types=1);

namespace VictoriaBabikova\DbWorkerApp\Database\RowGateway;

use PDO;
use PDOStatement;

class Film
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $duration = null;
    private ?int $manufacturer = null;
    private ?int $director = null;
    private ?string $description = null;
    private ?int $rental_company = null;
    private ?int $age_limits = null;
    private ?string $actors = null;
    private ?string $film_links = null;
    private PDO $pdo;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO public."Films"(id, name, duration, manufacturer, director, description, rental_company, age_limits, actors, film_links) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE public."Films" SET id=?, name=?, duration=?, manufacturer=?, director=?, description=?, rental_company=?, age_limits=?, actors=?, film_links=? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM public."Films" WHERE id = ?'
        );
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Film
     */
    public function setId(?int $id): Film
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Film
     */
    public function setName(?string $name): Film
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;
    }

    /**
     * @param string|null $duration
     * @return Film
     */
    public function setDuration(?string $duration): Film
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getManufacturer(): ?int
    {
        return $this->manufacturer;
    }

    /**
     * @param int|null $manufacturer
     * @return Film
     */
    public function setManufacturer(?int $manufacturer): Film
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDirector(): ?int
    {
        return $this->director;
    }

    /**
     * @param int|null $director
     * @return Film
     */
    public function setDirector(?int $director): Film
    {
        $this->director = $director;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Film
     */
    public function setDescription(?string $description): Film
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getRentalCompany(): ?int
    {
        return $this->rental_company;
    }

    /**
     * @param int|null $rental_company
     * @return Film
     */
    public function setRentalCompany(?int $rental_company): Film
    {
        $this->rental_company = $rental_company;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAgeLimits(): ?int
    {
        return $this->age_limits;
    }

    /**
     * @param int|null $age_limits
     * @return Film
     */
    public function setAgeLimits(?int $age_limits): Film
    {
        $this->age_limits = $age_limits;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getActors(): ?string
    {
        return $this->actors;
    }

    /**
     * @param string|null $actors
     * @return Film
     */
    public function setActors(?string $actors): Film
    {
        $this->actors = $actors;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilmLinks(): ?string
    {
        return $this->film_links;
    }

    /**
     * @param string|null $film_links
     * @return Film
     */
    public function setFilmLinks(?string $film_links): Film
    {
        $this->film_links = $film_links;

        return $this;
    }

    /**
     * @return int
     */
    public function insert(): int
    {
        $this->insertStatement->execute([
            $this->id,
            $this->name,
            $this->duration,
            $this->manufacturer,
            $this->director,
            $this->description,
            $this->rental_company,
            $this->age_limits,
            $this->actors,
            $this->film_links
        ]);
        $this->id = (int)$this->pdo->lastInsertId();

        return $this->id;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStatement->execute([
            $this->id,
            $this->name,
            $this->duration,
            $this->manufacturer,
            $this->director,
            $this->description,
            $this->rental_company,
            $this->age_limits,
            $this->actors,
            $this->film_links
        ]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $result = $this->deleteStatement->execute([$this->id]);
        $this->id = null;

        return $result;
    }
}
