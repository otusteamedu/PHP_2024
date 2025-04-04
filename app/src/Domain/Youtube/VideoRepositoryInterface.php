<?php

declare(strict_types=1);

namespace Valen\App\Domain\Youtube;

interface VideoRepositoryInterface
{
    public function save(Video $video): void;

    public function delete(string $videoId): void;

    public function findById(int $videoId): ?Video;

    public function findByChannelId(string $channelId): array;
}
