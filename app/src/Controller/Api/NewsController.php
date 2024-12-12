<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\News;
use App\Entity\Subscribe;
use App\Services\News\Observer\NewsItemCreateEvent;
use App\Services\News\Observer\NewsItemCreateEventSubscriber;
use App\Services\News\Observer\NewsItemEventPublisher;
use App\Services\News\Strategy\NewsItemHtmlContent;
use App\Services\News\Strategy\NewsItemPlainContent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/news')]
class NewsController extends AbstractController
{
    #[Route('Item', methods: ['POST'])]
    public function addNewsItemAction(Request $request, EntityManagerInterface $em, NewsItemEventPublisher $publisher): JsonResponse
    {
        $title = $request->get('title');
        $author = $request->get('author');
        $category = $request->get('category');
        $content = $request->get('content');

        if (empty($title) || empty($author) || empty($category) || empty($content)) {
            return new JsonResponse(['error' => 'заполните все поля!'], 400);
        }

        $publisher->subscribe(new NewsItemCreateEventSubscriber($em));

        try {
            $newsItem = new News();
            $newsItem->setAuthor($author)
                ->setCategory($category)
                ->setTitle($title)
                ->setContent($content);
            $em->persist($newsItem);
            $em->flush();

            $newsItemCreateEvent = new NewsItemCreateEvent($newsItem);
            $publisher->notify($newsItemCreateEvent);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse();
    }

    #[Route('', methods: ['GET'])]
    public function getNewsAction(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $news = $em->getRepository(News::class)->findAll();

        $type = $request->get('type');
        $contentDecorator = 'plain' == $type ? new NewsItemPlainContent() : new NewsItemHtmlContent();
        foreach ($news as $newsItem) {
            $content = $contentDecorator->getContent($newsItem->getContent());
            $newsItem->setContent($content);
        }

        return $this->json($news);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getNewsItemAction(News $newsItem, Request $request): JsonResponse
    {
        $type = $request->get('type');
        $contentDecorator = 'plain' == $type ? new NewsItemPlainContent() : new NewsItemHtmlContent();
        $content = $contentDecorator->getContent($newsItem->getContent());
        $newsItem->setContent($content);

        return $this->json($newsItem);
    }

    #[Route('/subscribe', methods: ['POST'])]
    public function subscribeAction(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $email = $request->get('email');
        $category = $request->get('category');

        if (empty($email)) {
            return new JsonResponse(['error' => 'введите email!'], 400);
        }

        try {
            $subscribe = new Subscribe();
            $subscribe->setCategory($category)
                ->setEmail($email);
            $em->persist($subscribe);
            $em->flush();
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse();
    }
}
