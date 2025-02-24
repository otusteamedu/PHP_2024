<?php

declare(strict_types=1);

namespace Otus\Hw16\Infrastructure\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Otus\Hw16\Application\UseCase\OrderFoodItemRequest;
use Otus\Hw16\Application\UseCase\OrderFoodItemUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderController
{
    public function __construct(
        private OrderFoodItemUseCase $useCase
    ) {
    }

    public function orderFoodItem(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            if (!isset($data['type']) || !is_string($data['type'])) {
                throw new \InvalidArgumentException('Field "type" is required and must be a string');
            }
            $type = $data['type'];
            $customIngredients = $data['customIngredients'] ?? [];

            $orderRequest = new OrderFoodItemRequest($type, $customIngredients);
            $response = ($this->useCase)($orderRequest);
            return new JsonResponse($response, 201);
        } catch (\RuntimeException $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }
}
