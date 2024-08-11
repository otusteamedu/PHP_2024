<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\NewsFilter;
use App\Http\Resources\V1\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class AuthorNewsController extends Controller
{
    public function index($author_id, NewsFilter $filters) {
        return NewsResource::collection(
            News::query()->where('user_id', $author_id)->filter($filters) ->paginate()
        );
    }
}
