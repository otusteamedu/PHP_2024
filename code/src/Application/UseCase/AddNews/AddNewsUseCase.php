<?php
declare(strict_types=1);

namespace App\Application\UseCase\AddNews;




use App\Application\UseCase\AddNews\Request\AddNewsRequest;
use App\Application\UseCase\AddNews\Response\AddNewsResponse;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;


class AddNewsUseCase
{
    private NewsRepositoryInterface $newsRepository;

    /**
     * @param NewsRepositoryInterface $newsRepository
     */
    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }


    public function add(AddNewsRequest $request): AddNewsResponse
    {
        $news = new News(
            new Url($request->url),
            new Title($request->title),
        );

        $this->newsRepository->save($news);
        return new AddNewsResponse($news->getId());
    }

}