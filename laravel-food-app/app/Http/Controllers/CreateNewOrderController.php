<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Layer\Application\UseCase\CreateNewOrderUseCase;
use App\Layer\Application\UseCase\Request\CreateNewOrderRequest;
use Symfony\Component\HttpFoundation\Response;

class CreateNewOrderController extends Controller
{
    public function __construct
    (
        private readonly CreateNewOrderUseCase $useCase
    )
    {}

    /**
     * @param CreateNewOrderRequest $request
     * @return Response
     */
    public function __invoke(CreateNewOrderRequest $request): Response
    {

        try {
            $newOrderResponse = ($this->useCase)($request);
            $view = response($newOrderResponse->order, 201);
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage() . " in ". $e->getFile() . " on ". $e->getLine(),
            ];
            $view = response($errorResponse, 400);
        }
        return $view;
    }
}
