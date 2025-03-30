<?php

namespace SergeyShirykalov\YoutubeChannels;

use SergeyShirykalov\YoutubeChannels\DTO\ChannelSummaryResponse;
use SergeyShirykalov\YoutubeChannels\DTO\VideoAddRequest;
use SergeyShirykalov\YoutubeChannels\DTO\VideoAddResponse;
use SergeyShirykalov\YoutubeChannels\DTO\VideoDTO;
use SergeyShirykalov\YoutubeChannels\DTO\VideoFindByTitleRequest;

readonly class VideoManager implements VideoStorageInterface
{
    public function __construct(private VideoStorageInterface $videoStorage)
    {
    }

    public function add(VideoAddRequest $videoAddRequest): VideoAddResponse
    {
        return $this->videoStorage->add($videoAddRequest);
    }

    public function delete(string $videoId): void
    {
        $this->videoStorage->delete($videoId);
    }

    public function seed(): void
    {
        $this->videoStorage->seed();
    }

    public function find(string $videoId): VideoDTO
    {
        return $this->videoStorage->find($videoId);
    }

    public function findByTitle(VideoFindByTitleRequest $request): VideoDTO
    {
        return $this->videoStorage->findByTitle($request);
    }

    public function channelSummary(string $channel): ChannelSummaryResponse
    {
        return $this->videoStorage->channelSummary($channel);
    }

    public function topChannelsByRatio(int $limit): array
    {
        return $this->videoStorage->topChannelsByRatio($limit);
    }

    public function storageInfo(): string
    {
        return $this->videoStorage->storageInfo();
    }
}
