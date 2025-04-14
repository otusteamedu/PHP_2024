<?php

namespace App\Services\Youtubechannel;

use App\Services\Youtubechannel\Repositories\SearchYoutubechannelRepository;
use App\Services\Youtubechannel\Repositories\WriteYoutubechannelRepository;
use Illuminate\Support\Collection;

class YoutubechannelServices
{

    const YOUTUBECHANNELS_UPDATED_QUEUE = 'youtubechannels:updated';

    private SearchYoutubechannelRepository $YoutubechannelRepository;
    /**
     * @var WriteYoutubechannelRepository
     */
    private WriteYoutubechannelRepository $writeYoutubechannelRepository;

    public function __construct(
        WriteYoutubechannelRepository $writeYoutubechannelRepository,
        SearchYoutubechannelRepository $YoutubechannelRepository
    )
    {
        $this->YoutubechannelRepository = $YoutubechannelRepository;
        $this->writeYoutubechannelRepository = $writeYoutubechannelRepository;
    }

    public function search(string $q): Collection
    {
        return $this->YoutubechannelRepository->search($q);
    }

    public function statistic(){

    }

}
