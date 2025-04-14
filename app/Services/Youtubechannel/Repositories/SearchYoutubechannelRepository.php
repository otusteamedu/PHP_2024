<?php

namespace App\Services\Youtubechannel\Repositories;


use Illuminate\Support\Collection;

interface SearchYoutubechannelRepository
{

    public function search(string $q): Collection;

}
