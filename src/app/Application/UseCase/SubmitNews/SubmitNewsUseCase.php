<?php

namespace App\Application\UseCase\SubmitNews;

use App\Domain\Entity\News;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;

class SubmitNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface    $factory,
        private readonly NewsRepositoryInterface $repository
    )
    {
    }

    public function __invoke(SubmitNewsRequest $request): SubmitNewsResponse
    {
        $news = $this->factory->create($this->getNameByUrl($request->url), $request->url, now());

        /** @var News $news */
        $news = $this->repository->save($news);

        return new SubmitNewsResponse($news->getId());
    }

    private function getNameByUrl($url)
    {
        $tag_regex = "'<title>(.*?)</title>'si";

        preg_match($tag_regex,
            file_get_contents($url),
            $matches);

        return $matches[1];
    }
}
