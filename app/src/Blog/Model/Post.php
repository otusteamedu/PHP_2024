<?php

declare(strict_types=1);

namespace App\Blog\Model;

use App\Shared\Model\AbstractModel;
use App\Shared\Model\Collection;

final class Post extends AbstractModel
{
    public function __construct(
        ?int $id,
        private string $title,
        private string $content,
        private PostStatus $status,
        /** @var Collection<PostComment> | null */
        private ?Collection $comments = null
    ) {
        parent::__construct($id);
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): PostStatus
    {
        return $this->status;
    }

    public function setStatus(PostStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<PostComment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function setComments(Collection $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getCommentsCount(): int
    {
        return (int) $this->comments?->count();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'content' => $this->getContent(),
            'status' => $this->getStatus()->value,
            'comments_count' => $this->getCommentsCount(),
        ];
    }

    public static function fromArray(array $data): static
    {
        return new self(
            $data['id'] ?? null,
            $data['title'],
            $data['content'],
            PostStatus::from($data['status']),
            $data['comments'] ?? null,
        );
    }
}
