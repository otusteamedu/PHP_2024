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
    public function __invoke(GetNewsListUseCase $getNewsList): Response
    {
        $result = call_user_func_array($getNewsList, []);

        return $this->json($result);
    }
}
