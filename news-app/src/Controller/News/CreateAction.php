<?php

declare(strict_types=1);

namespace App\Controller\News;

use App\News\Application\Factory\NotificationSenderFactory;
use App\News\Application\Request\CreateNewsRequest as AppCreateNewsRequest;
use App\News\Application\Services\NotifySubscribedUsersService;
use App\News\Application\UseCase\CreateNewsUseCase;
use App\News\Infrastructure\Observer\Publisher;
use App\News\Infrastructure\Repository\DbNewsRepository;
use App\NewsCategory\Infrastructure\Repository\DbNewsCategoryRepository;
use App\Request\News\CreateNewsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class CreateAction extends AbstractController
{
    public function __invoke(
        #[MapRequestPayload] CreateNewsRequest $createNewsRequest,
        DbNewsRepository $dbNewsRepository,
        DbNewsCategoryRepository $dbNewsCategoryRepository,
        ValidatorInterface $validator,
        NotificationSenderFactory $notificationSenderFactory
    ): JsonResponse
    {
        try {
            ($this->createNewsUseCase($dbNewsRepository, $dbNewsCategoryRepository, $notificationSenderFactory))(
                new AppCreateNewsRequest(
                    $createNewsRequest->title,
                    $createNewsRequest->content,
                    $createNewsRequest->categoryId
                )
            );
        } catch (Throwable $e) {
            return new JsonResponse([
               'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
            'success' => true
        ]);
    }

    private function createNewsUseCase(
        DbNewsRepository $dbNewsRepository,
        DbNewsCategoryRepository $dbNewsCategoryRepository,
        NotificationSenderFactory $notificationSenderFactory
    ): CreateNewsUseCase
    {
        $publisher = new Publisher();

        $publisher->subscribe(new NotifySubscribedUsersService($notificationSenderFactory));

        return new CreateNewsUseCase(
            $dbNewsRepository,
            $dbNewsCategoryRepository,
            $publisher
        );
    }
}