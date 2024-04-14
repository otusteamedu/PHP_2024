<?php

namespace App\Tests\UseCase;

use App\Application\UseCase\AddNewsUseCase;
use App\Application\UseCase\Request\AddNewsRequest;
use App\Application\UseCase\Response\AddNewsResponse;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddNewsTest extends KernelTestCase
{
    public function testAddNews(): void
    {
        self::bootKernel(["environment" => 'test']);
        $container = self::getContainer();
        $newsRepository = $container->get(NewsRepositoryInterface::class);

        $request = new AddNewsRequest('https://reintech.io/blog/use-php-file-get-contents-reading-files-urls');
        $useCase = $container->get(AddNewsUseCase::class);
        $response = ($useCase)($request);
        $this->assertInstanceOf(AddNewsResponse::class, $response);
        $this->assertEquals(1, $response->id);

        $newsList = $newsRepository->getByIds([1]);
        foreach ($newsList as $news) {
            $this->assertInstanceOf(News::class, $news);
            $this->assertNotEmpty($news->getId());
            $this->assertEquals(1, $news->getId());
            $this->assertNotEmpty($news->getTitle()->getValue());
        }

        $request = new AddNewsRequest('https://tomasvotruba.com/blog/how-to-create-symfony-kernel-for-tests-with-different-configs');
        $useCase = $container->get(AddNewsUseCase::class);;
        $response = ($useCase)($request);
        $this->assertInstanceOf(AddNewsResponse::class, $response);
        $this->assertEquals(2, $response->id);

        $newsList = $newsRepository->getByIds([2]);
        foreach ($newsList as $news) {
            $this->assertInstanceOf(News::class, $news);
            $this->assertNotEmpty($news->getId());
            $this->assertEquals(2, $news->getId());
            $this->assertNotEmpty($news->getTitle()->getValue());
        }
    }
}
