<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Main
{
    private static $app;

    protected function __construct()
    {
        session_start();
    }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }


    public static function getInstance(): Main
    {
        if (empty (self::$app)) {
            self::$app = new static();
        }
        return self::$app;
    }

    public function exec(): void
    {
        $status = Response::HTTP_OK;
        $content = "";

        $request = Request::createFromGlobals();
        $string = $request->request->getString('string');

        $stringBracketValidator = new StringBracketValidator($string);

        if ($stringBracketValidator->validate()) {
            $content .= "Строка: '" . $string . "' валидна" . PHP_EOL;
        }else{
            $content .= $stringBracketValidator->getErrorMessage(). PHP_EOL;;
            $status = Response::HTTP_BAD_REQUEST;
        }

        $content .= "Контейнер: " . $_SERVER['HOSTNAME'] . PHP_EOL;
        $content .= "Сервер: ".$_SERVER['SERVER_ADDR'] . PHP_EOL;
        $content .= "Сессия: " . session_id(). PHP_EOL;

        $response = new Response(
            $content,
            $status,
            ['content-type' => 'text/html']
        );

        $response->send();
    }


}