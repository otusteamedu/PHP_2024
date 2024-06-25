<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\GetNewsListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/news', name: 'news_list', methods: 'GET')]
class GetNewsListController extends AbstractController
{
    public function __construct(
        private readonly GetNewsListUseCase $getNewsList,
    ) {
    }

    public function __invoke(): Response
    {
        $result = ($this->getNewsList)();

        return $this->json($result);
    }
}
