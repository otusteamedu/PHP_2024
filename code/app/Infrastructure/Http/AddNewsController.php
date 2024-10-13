<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\AddNews\AddNewsRequest;
use App\Application\UseCase\AddNews\AddNewsUseCase;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;

readonly class AddNewsController
{
    public function __construct(
        private AddNewsUseCase $addNewsUseCase
    ) {
    }
    public function __invoke(Request $httpRequest)
    {
        $url = $httpRequest->json('url');

        $request = new AddNewsRequest($url);

        try {
            $response = ($this->addNewsUseCase)($request);

        } catch (InvalidArgumentException $ex) {
            return response($ex->getMessage(), 400);
        } catch (Exception) {
            return response('Server internal error', 500);
        }

        return response()->json(
            $response
        );
    }
}
