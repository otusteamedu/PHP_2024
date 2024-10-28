<?php

namespace Core;

use App\Application\UseCase\GetListNews\GetListNewsRequest;
use App\Application\UseCase\GetListNews\GetListNewsUseCase;
use App\Application\UseCase\GetNews\GetNewsRequest;
use App\Application\UseCase\GetNews\GetNewsUseCase;
use App\Application\UseCase\SubmitNews\SubmitNewsRequest;
use App\Application\UseCase\SubmitNews\SubmitNewsUseCase;
use App\Application\UseCase\SubmitSubscribe\SubmitSubscribeRequest;
use App\Application\UseCase\SubmitSubscribe\SubmitSubscribeUseCase;
use App\Infrastructure\Command\GetListNewsCommand;
use App\Infrastructure\Command\GetNewsCommand;
use App\Infrastructure\Command\SubmitNewsCommand;
use App\Infrastructure\Command\SubmitSubscribeCommand;
use App\Infrastructure\Decorator\NewsLinkDecorator;
use App\Infrastructure\Decorator\NewsReadTimeDecorator;
use App\Infrastructure\Factory\CommonNewsFactory;
use App\Infrastructure\Factory\CommonSubscribeFactory;
use App\Infrastructure\Observer\NewsCreate;
use App\Infrastructure\Output\NewsHtmlStrategy;
use App\Infrastructure\Output\NewsPlainTextStrategy;
use App\Infrastructure\Repository\NewsPrepare;
use App\Infrastructure\Repository\NewsRepository;
use App\Infrastructure\Repository\SubscribeRepository;

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
        $Subscribe = new NewsCreate();
        $UseCase = new SubmitNewsUseCase($CommonNewsFactory, $Repository, $Subscribe);
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
        $Strategy = new NewsPlainTextStrategy();
        $UseCase = new GetNewsUseCase($Repository, $Strategy);
        $Command = new GetNewsCommand($UseCase);
        $Request = new GetNewsRequest($id);
        $Response = $Command($Request);
        $NewsPrepare = new NewsPrepare($Response->text);
        $Response->text = (new NewsReadTimeDecorator((new NewsLinkDecorator($NewsPrepare))))->getText();

        return (array)$Response;
    }
    public static function getAll()
    {
        $Repository = new NewsRepository();
        $OutputText = new NewsPlainTextStrategy();
        $UseCase = new GetListNewsUseCase($Repository, $OutputText);
        $Command = new GetListNewsCommand($UseCase);
        $Request = new GetListNewsRequest();
        return (array)$Command($Request);
    }
    public static function subcribe(int $user_id, string $category)
    {
        // todo
        $Common = new CommonSubscribeFactory();
        $Repository = new SubscribeRepository();
        $UseCase = new SubmitSubscribeUseCase($Common, $Repository);
        $Command = new SubmitSubscribeCommand($UseCase);
        $Request = new SubmitSubscribeRequest($user_id, $category);
        return $Command($Request);
    }

}