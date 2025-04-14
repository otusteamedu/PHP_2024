<?php
/**
 * Description of EloquentYoutubechannelRepository.php
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace App\Services\Youtubechannel\Repositories;


use App\Models\Youtubechannel;
use Illuminate\Support\Collection;

class EloquentSearchYoutubechannelRepository implements SearchYoutubechannelRepository
{

    public function search(string $q): Collection
    {
        $qb = Youtubechannel::query();
        if ($q) {
            $qb->where('name', 'like', "%{$q}%");
        }

        return $qb->get();
    }


}
