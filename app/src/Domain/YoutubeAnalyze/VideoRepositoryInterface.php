<?php

declare(strict_types=1);

namespace Valen\App\Domain\YoutubeAnalyze;

interface VideoRepositoryInterface
{
    public function save(Video $video): void;

    public function delete(string $videoId): void;

    public function findById(string $videoId): ?Video;

    public function findByChannelId(string $channelId): array;
}
