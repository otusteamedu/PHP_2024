<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Response\CreateNewsResponse;
use App\Domain\Contract\RepositoryInterface;
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
     * @throws TitleValidateException
     * @throws Exception
     */
    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $title = new Title($request->title);
        $date = new Date($request->date);
        $url = new Url($request->url);

        $news = new News((string) $date, $url->getValue(), $title->getValue());

        return new CreateNewsResponse($this->repository->save($news));
    }
}
