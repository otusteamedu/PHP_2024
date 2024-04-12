<?php
declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Api\v1\News\Create;

use App\Application\UseCase\NewsCreateUseCase\NewsCreateUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(
    '/api/v1/news/create',
    name: 'news_create',
    methods: ['POST']
)]
final class CreateNewsController extends AbstractController
{
    public function __construct(
        private NewsCreateUseCase $newsCreateUseCase,
        private SerializerInterface $serializer,
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        $result = $this->newsCreateUseCase->__invoke($payload);

        $serializedResult = $this->serializer->serialize($result, 'json');

        return new JsonResponse(data: $serializedResult, json: true);
    }
}
