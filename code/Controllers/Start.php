<?php
namespace Controllers;

use Core\App;
use Core\Router;
use Core\View;

class Start
{
    public function index()
    {
        (new View())->generate('start');

    }
    public function newsById()
    {
        $news = App::getById($_GET['id']);

        (new View())->generate('news', ['news' => $news]);
    }

    public function news()
    {
        $news = App::getAll();

        (new View())->generate('news_list', ['data' => $news]);
    }

    public function set()
    {
        (new View())->generate('set');
    }

    public function subscribe()
    {
        (new View())->generate('subscribe');
    }

    public function post_setNews()
    {
        $params = Router::getParams()['POST'];

        Router::showJson(!empty($data = App::add($params['name'], $params['author'], $params['category'], $params['text']))
            ? Router::buildSuccess(['id' => $data->id])
            : Router::buildError('extra opening parenthesis')
        );

    }
    public function post_subscribe()
    {
        $params = Router::getParams()['POST'];

        Router::showJson(!empty($data = App::subcribe($params['user_id'], $params['category']))
            ? Router::buildSuccess(['id' => $data->id])
            : Router::buildError('extra opening parenthesis')
        );

    }
}