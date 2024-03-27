<?php

declare(strict_types=1);

namespace Hukimato\EsApp;

class App
{
    protected ParamsParser $paramsParser;
    protected View $view;

    public function __construct()
    {
        $this->paramsParser = new ParamsParser();
        $this->view = new View();
    }

    public function run()
    {
        $params = $this->paramsParser->parse();
        $books = Book::find($params);
        $this->view->render($books);
    }
}
