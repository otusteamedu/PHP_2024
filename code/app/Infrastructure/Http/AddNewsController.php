<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\AddNews\AddNewsRequest;
use App\Application\UseCase\AddNews\AddNewsUseCase;
use Illuminate\Http\Request;

class AddNewsController
{
    public function __construct(
        private AddNewsUseCase $addNewsUseCase
    ) {}
    public function __invoke(Request $httpRequest)
    {
        $url = $httpRequest->json('url');

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return response('URL is invalid', 400);
        }

        $request = new AddNewsRequest($url);

        try {
            $response = ($this->addNewsUseCase)($request);
        } catch (\Exception) {
            return response('Server internal error', 500);
        }

        return response()->json(
            [
                'id' => $response->id
            ]
        );
    }
}
