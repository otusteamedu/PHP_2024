<?php

declare(strict_types=1);

namespace App\Dto;

final readonly class VideoDTO
{
    public function __construct(
        private string $id,
        private string $channel_id,
        private string $title,
        private string $description,
        private int $likes,
        private int $dislikes
    ) {
        
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    public function getChannelId(): string
    {
        return $this->channel_id;
    }
}
