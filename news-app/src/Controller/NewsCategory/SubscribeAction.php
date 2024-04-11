<?php

declare(strict_types=1);

namespace App\Controller\NewsCategory;

use App\NewsCategory\Application\Factory\SubscriberFactory;
use App\NewsCategory\Application\UseCase\SubscribeToCategoryUseCase;
use App\Request\CategorySubscribe\CategorySubscribeRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Throwable;

class SubscribeAction extends AbstractController
{
    public function __invoke(
        #[MapRequestPayload] CategorySubscribeRequest $categorySubscribeRequest,
        SubscriberFactory $subscriberFactory,
        SubscribeToCategoryUseCase $subscribeToCategoryUseCase
    ): JsonResponse
    {
        try {
            $subscriber = $subscriberFactory->getSubscriber(
                $categorySubscribeRequest->type,
                $categorySubscribeRequest->value
            );

            $subscribeToCategoryUseCase($categorySubscribeRequest->categoryId, $subscriber);
        } catch (Throwable $e) {
            return new JsonResponse([
               'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
           'success' => true
        ]);
    }
}