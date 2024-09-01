<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Actions\CreateNewsAction;
use App\Application\Requests\CreateNewsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function create(Request $request, CreateNewsAction $action): JsonResponse
    {
        $createNewsRequest = new CreateNewsRequest($request->url);

        $createNewsResponse = call_user_func($action, $createNewsRequest);

        return response()->json([
            'message' => 'Article created successful.',
            'data' => get_object_vars($createNewsResponse),
        ]);
    }
}
