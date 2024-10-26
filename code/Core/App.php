<?php

namespace Core;

use App\Application\UseCase\GetNews\GetNewsRequest;
use App\Application\UseCase\GetNews\GetNewsUseCase;
use App\Application\UseCase\SubmitNews\SubmitNewsRequest;
use App\Application\UseCase\SubmitNews\SubmitNewsUseCase;
use App\Infrastructure\Command\GetNewsCommand;
use App\Infrastructure\Command\SubmitNewsCommand;
use App\Infrastructure\Factory\CommonNewsFactory;
use App\Infrastructure\Output\HtmlNewsPrepareText;
use App\Infrastructure\Output\PlainTextNewsPrepareText;
use App\Infrastructure\Output\ReadTimeAppended;
use App\Infrastructure\Repository\NewsRepository;

class App
{


    public function run()
    {
        $args = $_SERVER['argv'];

        switch ($args[1]) {
            case 'add': // '{"name": "news 1", "author": "author 1", "category": "sport", "text": "this <b>news</b> about ..."}'
                $this->add($args[2]);
                break;
            case 'getById': // 1
                $this->getById($args[2]);
                break;
            default:
                throw new \Exception('Command not found');
        }
    }

    private function add(string $news_json = null)
    {
        $news_json = !empty($news_json) ? json_decode($news_json, true) : null;
        if (empty($news_json)) {
            throw new \Exception('Error in news string');
        }

        $CommonNewsFactory = new CommonNewsFactory();
        $NewsRepository = new NewsRepository();
        $SubmitNewsUseCase = new SubmitNewsUseCase($CommonNewsFactory, $NewsRepository);
        $SubmitNewsCommand = new SubmitNewsCommand($SubmitNewsUseCase);
        $SubmitNewsRequest = new SubmitNewsRequest($news_json['name'], $news_json['author'], $news_json['category'], $news_json['text']);
        $result = $SubmitNewsCommand($SubmitNewsRequest);
        var_dump("id in storage: ".$result->id);
    }

    private function getById(int $id = null)
    {
        if (empty($id)) {
            throw new \Exception('Error in params');
        }

        $NewsRepository = new NewsRepository();
        $NewsOutputText = new HtmlNewsPrepareText();
//        $Appended = new ReadTimeAppended();
        $GetNewsUseCase = new GetNewsUseCase($NewsRepository, $NewsOutputText);
        $GetNewsCommand = new GetNewsCommand($GetNewsUseCase);
        $GetNewsRequest = new GetNewsRequest($id);
        $result = $GetNewsCommand($GetNewsRequest);
        var_dump($result);
//        var_dump("id in storage: ".$result->id);
    }

}