<?php
declare(strict_types=1);

namespace App\Application\UseCase\AddNews;




use App\Application\UseCase\AddNews\Request\AddNewsRequest;
use App\Application\UseCase\AddNews\Response\AddNewsResponse;
use App\Domain\Entity\News;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;


class AddNewsUseCase
{
    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $news = new News(
            new Url($request->url),
            new Title($request->title),
            new Date($request->date)
        );



    }

}