<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Gateway\ClientInterface;
use App\Application\Gateway\Request\NewsRequest;
use App\Application\Helper\NewsTitleExtractorInterface;
use App\Application\UseCase\Form\CreateNewsForm;
use App\Application\UseCase\Response\CreateNewsResponse;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

readonly class CreateNewsUseCase
{
    public function __construct(
        private ClientInterface             $client,
        private NewsRepositoryInterface     $newsRepository,
        private NewsTitleExtractorInterface $newsTitleExtractor,
    )
    {
    }

    public function __invoke(CreateNewsForm $form): CreateNewsResponse
    {
        $newsResponse = $this->client->get(new NewsRequest($form->url));

        $title = $this->newsTitleExtractor->extractTitle($newsResponse);
        $news = new News(new Url($form->url), new Title($title), new \DateTime());

        $this->newsRepository->add($news);

        return new CreateNewsResponse($news->getId());
    }
}
