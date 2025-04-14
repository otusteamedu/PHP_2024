<?php

namespace App\Services\Youtubechannel\Repositories;
interface WriteYoutubechannelRepository
{
    public function create(array $data): int;
    public function update(int $id, array $data): void;
}
