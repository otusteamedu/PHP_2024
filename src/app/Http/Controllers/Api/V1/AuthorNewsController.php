<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\NewsFilter;
use App\Http\Requests\Api\V1\ReplaceNewsRequest;
use App\Http\Requests\Api\V1\StoreNewsRequest;
use App\Http\Requests\Api\V1\UpdateNewsRequest;
use App\Http\Resources\V1\NewsResource;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthorNewsController extends ApiController
{
    public function index($author_id, NewsFilter $filters) {
        return NewsResource::collection(
            News::query()->where('user_id', $author_id)->filter($filters) ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($author_id, StoreNewsRequest $request)
    {

        return new NewsResource(News::query()->create($request->mappedAttributes()));
    }

    public function destroy($author_id, $news_id)
    {
        try {
            $news = News::query()->findOrFail($news_id);

            if($news->user_id == $author_id) {
                $news->delete();
                return $this->ok('News successfully deleted');
            }

            return $this->error('News can not be found', 404);

        } catch (ModelNotFoundException $exception) {
            return $this->error('News can not be found', 404);
        }
    }

    public function replace(ReplaceNewsRequest $request, $author_id, $news_id)
    {
        try {
            $news = News::query()->findOrFail($news_id);

            if ($news->user_id == $author_id) {
                $news->update($request->mappedAttributes());
            }

            //TODO news does not belong to author

            return new NewsResource($news);

        } catch (ModelNotFoundException) {
            return $this->error('News can not be found', 404);
        }
    }

    public function update(UpdateNewsRequest $request, $author_id, $news_id)
    {
        try {
            $news = News::query()->findOrFail($news_id);

            if ($news->user_id == $author_id) {
                $news->update($request->mappedAttributes());
            }

            //TODO news does not belong to author

            return new NewsResource($news);

        } catch (ModelNotFoundException) {
            return $this->error('News can not be found', 404);
        }
    }

}
