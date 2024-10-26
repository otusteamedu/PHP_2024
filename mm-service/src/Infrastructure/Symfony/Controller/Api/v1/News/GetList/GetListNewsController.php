<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Api\v1\News\GetList;

use App\Application\UseCase\NewsGetListUseCase\NewsGetListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(
    '/api/v1/news',
    name: 'news_list',
    methods: ['GET']
)]
final class GetListNewsController extends AbstractController
{
    public function __construct(
        private NewsGetListUseCase $newsGetListUseCase,
        private SerializerInterface $serializer,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->newsGetListUseCase->__invoke();

        $serializedResult = $this->serializer->serialize(
            $result,
            'json',
            [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s']
        );

        return new JsonResponse(data: $serializedResult, json: true);
    }
}
