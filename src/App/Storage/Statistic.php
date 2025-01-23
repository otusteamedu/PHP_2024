<?php

namespace App\Storage;

interface Statistic
{
    public function getLikesAndDislikesByChannel(string $channelId): array;

    public function getBestChannelRatio(int $count = 3): array;
}