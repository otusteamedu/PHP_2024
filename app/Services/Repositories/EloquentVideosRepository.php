<?php

namespace App\Services\Repositories;

use App\Models\Videos;
use Illuminate\Support\Collection;
class EloquentVideosRepository implements VideosRepository
{

    public function getAll(): Collection
    {
        return Videos::query()->get();
    }
}
