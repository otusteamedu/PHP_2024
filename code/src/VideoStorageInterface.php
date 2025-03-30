<?php

namespace SergeyShirykalov\YoutubeChannels;

use SergeyShirykalov\YoutubeChannels\DTO\ChannelSummaryResponse;
use SergeyShirykalov\YoutubeChannels\DTO\TopChannelItemDTO;
use SergeyShirykalov\YoutubeChannels\DTO\VideoAddRequest;
use SergeyShirykalov\YoutubeChannels\DTO\VideoAddResponse;
use SergeyShirykalov\YoutubeChannels\DTO\VideoFindByTitleRequest;
use SergeyShirykalov\YoutubeChannels\DTO\VideoDTO;

interface VideoStorageInterface
{
    /**
     * @param VideoAddRequest $videoAddRequest
     * @return VideoAddResponse
     */
    public function add(VideoAddRequest $videoAddRequest): VideoAddResponse;

    /**
     * @param string $videoId
     * @return void
     */
    public function delete(string $videoId): void;

    /**
     * @param string $videoId
     * @return mixed
     */
    public function find(string $videoId): VideoDTO;

    /**
     * @param VideoFindByTitleRequest $request
     * @return VideoDTO
     */
    public function findByTitle(VideoFindByTitleRequest $request): VideoDTO;

    public function channelSummary(string $channel): ChannelSummaryResponse;

    /**
     * @param int $limit
     * @return TopChannelItemDTO[]
     */
    public function topChannelsByRatio(int $limit): array;

    /**
     * Первоначальное заполнение тестовыми данными
     *
     * @return void
     */
    public function seed(): void;

    public function storageInfo(): string;
}
