<?php

declare(strict_types=1);

namespace App\Domain\News;

use App\Domain\Category\Category;
use App\Domain\Exporter\ExportableInterface;
use App\Domain\Exporter\ExporterInterface;
use App\Domain\State\AbstractState;
use App\Domain\State\ConcreteStates\Draft;
use App\Domain\User\User;
use DateTime;
use DOMDocument;
use JsonSerializable;

class News implements JsonSerializable, ExportableInterface
{
    protected ?int $id;

    protected string $title;

    protected \DateTime $createdAt;

    protected User $author;

    protected Category $category;

    protected ?string $body;

    protected AbstractState $state;

    public function __construct(
        ?int     $id,
        string   $title,
        User     $author,
        DateTime $createdAt,
        Category   $category,
        string   $body,
        AbstractState    $state = new Draft(),
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->createdAt = $createdAt;
        $this->category = $category;
        $this->state = $state;
        $this->body = $body;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): News
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): News
    {
        $this->title = $title;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): News
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): News
    {
        $this->author = $author;
        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): News
    {
        $this->category = $category;
        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): News
    {
        $this->body = $body;
        return $this;
    }

    public function getState(): AbstractState
    {
        return $this->state;
    }

    public function setState(AbstractState $state): News
    {
        $this->state = $this->state->getAllowedTransition($state);
        return $this;
    }

    public function accept(ExporterInterface $exporter)
    {
        $exporter->exportNews($this);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'author' => $this->author,
            'category' => $this->category,
            'body' => $this->body,
        ];
    }
}
