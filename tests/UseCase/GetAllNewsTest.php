<?php

namespace App\Tests\UseCase;

use App\Application\UseCase\AddNewsUseCase;
use App\Application\UseCase\GetAllNewsUseCase;
use App\Application\UseCase\Request\AddNewsRequest;
use App\Application\UseCase\Response\AddNewsResponse;
use App\Application\UseCase\Response\NewsResponse;
use App\Domain\Entity\News;
use App\Infrastructure\Http\GetAllNewsController;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetAllNewsTest extends KernelTestCase
{
    public function testGetAllNews(): void
    {
        self::bootKernel(["environment" => 'test']);
        $container = self::getContainer();

        $request = new AddNewsRequest('https://reintech.io/blog/use-php-file-get-contents-reading-files-urls');
        $addUseCase = $container->get(AddNewsUseCase::class);;
        ($addUseCase)($request);

        $getAllUseCase = $container->get(GetAllNewsUseCase::class);;
        $news = ($getAllUseCase)();
        $this->assertCount(1, $news);

        foreach ($news as $new) {
            $this->assertInstanceOf(NewsResponse::class, $new);
        }

        $request = new AddNewsRequest('https://tomasvotruba.com/blog/how-to-create-symfony-kernel-for-tests-with-different-configs');
        $addUseCase = $container->get(AddNewsUseCase::class);;
        ($addUseCase)($request);

        $getAllUseCase = $container->get(GetAllNewsUseCase::class);;
        $news = ($getAllUseCase)();
        $this->assertCount(2, $news);
        foreach ($news as $new) {
            $this->assertInstanceOf(NewsResponse::class, $new);
        }
    }
}
