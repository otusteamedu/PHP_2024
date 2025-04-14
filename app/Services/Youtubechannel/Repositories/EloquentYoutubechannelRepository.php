<?php
namespace App\Services\Youtubechannel\Repositories;

use App\Models\Youtubechannel;

class EloquentYoutubechannelRepository implements WriteYoutubechannelRepository
{
    public function create(array $data): int
    {
        return Youtubechannel::create($data)->id;
    }

    public function update(int $id, array $data): void
    {
        Youtubechannel::find($id)->update($data);
    }
}
