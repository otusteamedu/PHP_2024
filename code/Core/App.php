<?php

namespace Core;

use App\Application\UseCase\GetListNews\GetListNewsUseCase;
use App\Application\UseCase\GetListNews\GetListNewsRequest;
use App\Application\UseCase\GetNews\GetNewsRequest;
use App\Application\UseCase\GetNews\GetNewsUseCase;
use App\Application\UseCase\SubmitNews\SubmitNewsRequest;
use App\Application\UseCase\SubmitNews\SubmitNewsUseCase;
use App\Domain\Entity\News;
use App\Infrastructure\Command\GetListNewsCommand;
use App\Infrastructure\Command\GetNewsCommand;
use App\Infrastructure\Command\SubmitNewsCommand;
use App\Infrastructure\Factory\CommonNewsFactory;
use App\Infrastructure\Output\HtmlNewsPrepareText;
use App\Infrastructure\Output\LinkAppended;
use App\Infrastructure\Output\PlainTextNewsPrepareText;
use App\Infrastructure\Output\ReadTimeAppended;
use App\Infrastructure\Repository\NewsRepository;

class App
{


    public function run()
    {
        Router::start();
    }

    public static function add(string $name, string $author, string $category, string $text)
    {
        $CommonNewsFactory = new CommonNewsFactory();
        $Repository = new NewsRepository();
        $UseCase = new SubmitNewsUseCase($CommonNewsFactory, $Repository);
        $Command = new SubmitNewsCommand($UseCase);
        $Request = new SubmitNewsRequest($name, $author, $category, $text);
        return $Command($Request);
    }

    public static function getById(int $id = null)
    {
        if (empty($id)) {
            throw new \Exception('Error in params');
        }

        $Repository = new NewsRepository();
        $NewsOutputText = new HtmlNewsPrepareText();
        $reflectionClass = new \ReflectionClass(News::class);
        $news = $reflectionClass->newInstanceWithoutConstructor();
        $Appended = new LinkAppended((new ReadTimeAppended($news)));
        $UseCase = new GetNewsUseCase($Repository, $NewsOutputText, $Appended);
        $Command = new GetNewsCommand($UseCase);
        $Request = new GetNewsRequest($id);
        return (array)$Command($Request);
    }
    public static function getAll()
    {
        $Repository = new NewsRepository();
        $OutputText = new PlainTextNewsPrepareText();
        $UseCase = new GetListNewsUseCase($Repository, $OutputText);
        $Command = new GetListNewsCommand($UseCase);
        $Request = new GetListNewsRequest();
        return (array)$Command($Request);
    }
    public static function subcribe()
    {
        $Repository = new NewsRepository();
        $OutputText = new PlainTextNewsPrepareText();
        $UseCase = new GetListNewsUseCase($Repository, $OutputText);
        $Command = new GetListNewsCommand($UseCase);
        $Request = new GetListNewsRequest();
        return (array)$Command($Request);
    }

}