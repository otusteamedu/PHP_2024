<?php

namespace SergeyShirykalov\YoutubeChannels;

readonly class ChannelManager
{
    public function __construct(private ChannelStorageInterface $channelStorage)
    {
    }

    public function add(array $videoInfo): void
    {
        $this->channelStorage->add($videoInfo);
    }

    public function delete(string $videoName, string $channelName): void
    {
        $this->channelStorage->delete($videoName, $channelName);
    }

    public function channelInfo(string $channelName): ?array
    {
        return $this->channelStorage->info($channelName);
    }

    public function storageInfo(): ?array
    {
        return $this->channelStorage->info();
    }

    public function topChannels(): ?array
    {
        return [];
    }

    public function seed(): void
    {

    }
}
