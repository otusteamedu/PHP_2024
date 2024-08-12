<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\NewsFilter;
use App\Http\Requests\Api\V1\StoreNewsRequest;
use App\Http\Requests\Api\V1\UpdateNewsRequest;
use App\Http\Resources\V1\NewsResource;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;

class NewsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(NewsFilter $filters)
    {

        return NewsResource::collection(News::filter($filters)->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        try {
            User::query()->findOrFail($request->input('data.relationships.author.data.id'));
        } catch (ModelNotFoundException) {
            return $this->ok('User not found', [
                'error' => 'The provided user id does not exist'
            ]);
        }

        $model = [
            'title' => $request->input('data.attributes.title'),
            'body' => $request->input('data.attributes.body'),
            'category' => $request->input('data.attributes.category'),
            'user_id' => $request->input('data.relationships.author.data.id'),
        ];

        return new NewsResource(News::query()->create($model));
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news): NewsResource
    {
        if($this->include('author')) {
            return new NewsResource($news->load('user'));
        }
        return new NewsResource($news);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
    }
}
