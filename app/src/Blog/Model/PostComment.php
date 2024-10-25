<?php

declare(strict_types=1);

namespace App\Blog\Model;

use App\Shared\Model\AbstractModel;

final class PostComment extends AbstractModel
{
    public function __construct(
        ?int $id,
        private ?int $postId,
        private string $content,
    ) {
        parent::__construct($id);
    }

    public function getPostId(): ?int
    {
        return $this->postId;
    }

    public function setPostId(int $postId): self
    {
        $this->postId = $postId;

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

    public static function fromArray(array $data): static
    {
        return new self(
            $data['id'] ?? null,
            $data['post_id'],
            $data['content'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'post_id' => $this->getPostId(),
            'content' => $this->getContent(),
        ];
    }
}
