<?php

namespace App\Http\Controllers\Youtubechannel;

use App\Http\Controllers\Controller;
use App\Services\Youtubechannel\Statistic;
use App\Services\Youtubechannel\YoutubechannelServices;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    private YoutubechannelServices $service;

    public function __construct(YoutubechannelServices $service)
    {
        $this->service = $service;

    }

    public function __invoke(Request $request)
    {
        $search = $request->get('q', '');
        $top = $request->get('top', 10);
        $statistic = new Statistic();

        $youtubechannel = $statistic->getTopChannels($this->service->search($search), $top);

        return view('youtubechannels.index', [
            'youtubechannels' => $youtubechannel,
            'search' => $search,
            'top' => $top
        ]);
    }

}
