<?php

namespace App\Http\Controllers;

use App\Services\Repositories\EloquentVideosRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
class VideosController extends Controller
{
    /**
     * @var EloquentVideosRepository
     */
    private EloquentVideosRepository $eloquentVideosRepository;

    /**
     * @param EloquentVideosRepository $eloquentVideosRepository
     */
    public function __construct(EloquentVideosRepository $eloquentVideosRepository)
    {
        $this->eloquentVideosRepository = $eloquentVideosRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function __invoke()
    {
        $videos = $this->eloquentVideosRepository->getAll();

        return view('videos',['videos' => $videos]);
    }
}
