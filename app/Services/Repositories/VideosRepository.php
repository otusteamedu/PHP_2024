<?php

namespace App\Services\Repositories;

use Illuminate\Support\Collection;
interface VideosRepository
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;
}
