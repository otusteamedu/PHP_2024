<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Contract\RepositoryInterface;
use App\Application\Exception\NewsNotCreatedException;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Response\CreateNewsResponse;
use App\Domain\Entity\News;
use App\Domain\Exception\Validate\TitleValidateException;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use Exception;

final class CreateNews
{
    public function __construct(private readonly RepositoryInterface $repository)
    {
    }

    /**
     * @throws NewsNotCreatedException
     * @throws TitleValidateException
     * @throws Exception
     */
    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $news = new News();

        $title = new Title($request->title);
        $date = new Date($request->date);
        $url = new Url($request->url);

        $news->setTitle($title->getValue());
        $news->setDate((string) $date);
        $news->setUrl($url->getValue());
        $this->repository->save($news);

        return new CreateNewsResponse($this->repository->getLastInsertId());
    }
}
