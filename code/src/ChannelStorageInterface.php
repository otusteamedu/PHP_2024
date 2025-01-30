<?php

namespace SergeyShirykalov\YoutubeChannels;

interface ChannelStorageInterface
{
    public function add(array $videoInfo): void;
    public function delete(string $videoName, string $channelName): void;
    public function info(string $videoName);
}
