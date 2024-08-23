<?php
namespace Controllers;

use Core\Router;
use Core\View;

class Start
{
    public function index()
    {
        (new View())->generate('start');

    }

    public function post_string()
    {
        $params = Router::getParams()['POST'];

        if (empty($params['string'])) {
            Router::showJson(Router::buildError('empty string'));
        }

        $string = $params['string'];
        $helper_count = 0;

        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            if ($char === '(') {
                $helper_count++;
            } else if ($char === ')') {
                $helper_count--;
            }
            if ($helper_count < 0) {
                Router::showJson(Router::buildError('extra closing parenthesis'));
            }
        }

        Router::showJson($helper_count === 0
            ? Router::buildSuccess()
            : Router::buildError('extra opening parenthesis')
        );

    }
}