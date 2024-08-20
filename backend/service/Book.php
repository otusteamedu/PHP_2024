<?php

declare(strict_types=1);

namespace Service;

class Book
{
    private ?int $id = null;
    private string $name;
    private int $author_id;
    private \DateTimeImmutable $date_of_issue;
    private ?float $rating = null;
    private int $number_of_copies;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    public function setAuthorId(int $author_id): void
    {
        $this->author_id = $author_id;
    }

    public function getDateOfIssue(): \DateTimeImmutable
    {
        return $this->date_of_issue;
    }

    public function setDateOfIssue(\DateTimeImmutable $date_of_issue): void
    {
        $this->date_of_issue = $date_of_issue;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): void
    {
        $this->rating = $rating;
    }

    public function getNumberOfCopies(): int
    {
        return $this->number_of_copies;
    }

    public function setNumberOfCopies(int $number_of_copies): void
    {
        $this->number_of_copies = $number_of_copies;
    }
}
