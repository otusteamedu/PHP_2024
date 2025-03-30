<?php

declare(strict_types=1);

namespace Domain\Repository;

use Domain\Model\Channel;

interface ChannelRepositoryInterface
{
    public function save(Channel $channel): void;
    public function delete(string $channelId): void;
    public function findById(string $channelId): ?Channel;
    public function findAll(int $limit = 100, int $offset = 0): array;
}