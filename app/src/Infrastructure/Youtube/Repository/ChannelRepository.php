<?php

namespace Valen\App\Infrastructure\Youtube\Repository;

use Valen\App\Domain\Youtube\Channel;
use Valen\App\Domain\Youtube\ChannelRepositoryInterface;

class ChannelRepository implements ChannelRepositoryInterface
{
    public function save(Channel $channel): void
    {
        // TODO: Implement save() method.
    }

    public function delete(string $channelId): void
    {
        // TODO: Implement delete() method.
    }

    public function findById(int $channelId): ?Channel
    {
        // TODO: Implement findById() method.
    }

    public function findAll(int $limit = 100, int $offset = 0): array
    {
        // TODO: Implement findAll() method.
    }
}
