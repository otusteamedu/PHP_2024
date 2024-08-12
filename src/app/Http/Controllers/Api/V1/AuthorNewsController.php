<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\NewsFilter;
use App\Http\Requests\Api\V1\StoreNewsRequest;
use App\Http\Resources\V1\NewsResource;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthorNewsController extends Controller
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

        $model = [
            'title' => $request->input('data.attributes.title'),
            'body' => $request->input('data.attributes.body'),
            'category' => $request->input('data.attributes.category'),
            'user_id' => $author_id,
        ];

        return new NewsResource(News::query()->create($model));
    }

}
