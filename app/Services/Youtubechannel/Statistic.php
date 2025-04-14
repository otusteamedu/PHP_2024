<?php

namespace App\Services\Youtubechannel;

use App\Models\Youtubechannel;
use Illuminate\Support\Collection;

class Statistic
{
    public function getStatistic(Youtubechannel $youtubechannel){

        foreach (@$youtubechannel->videos as $video){
            $youtubechannel->totalLike += $video['like'];
            $youtubechannel->totaldislikes += $video['dislikes'];
        }

        return $youtubechannel;
    }

    public function getTopChannels(Collection $youtubechannels, int $n = 5 ){

        foreach (@$youtubechannels as $youtubechannel) {
            foreach (@$youtubechannel->videos as $video) {
                $youtubechannel->totalLike += $video['like'];
                $youtubechannel->totaldislikes += $video['dislikes'];
            }
            $youtubechannel->raiting = $youtubechannel->totalLike - $youtubechannel->totaldislikes;
        }

        return $youtubechannels->sortByDesc('raiting')->take($n);
    }

}
