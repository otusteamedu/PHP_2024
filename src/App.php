<?php

namespace App;

use RedisConnector\RedisConnector;
use ResponseFormatter\ResponseFormatter;
use StringAnalyzer\StringAnalyzer;

class App
{
    private StringAnalyzer $analyzer;
    private RedisConnector $redisConnector;

    public function __construct()
    {
        $this->analyzer = new StringAnalyzer();
        $this->redisConnector = new RedisConnector();
    }

    public function run(): string
    {
        if (empty($_POST['string'])) {
            return ResponseFormatter::jsonResponse([
                'success' => false,
                'message' => 'Строка не найдена в POST запросе',
            ], 400);
        }

        $string = $_POST['string'];
        $isBracketsCorrect = $this->analyzer->checkBrackets($string);
        $redisConnect = $this->redisConnector->connect();
        $container = $_SERVER['HOSTNAME'];

        if ($isBracketsCorrect) {
            $data = [
                'RedisConnect' => $redisConnect,
                'success' => true,
                'message' => 'Строка корректна',
                'Контейнер' => $container,
            ];
            $statusCode = 200;
        } else {
            $data = [
                'success' => false,
                'message' => 'Строка некорректна',
                'Контейнер' => $container,
            ];
            $statusCode = 400;
        }

        return ResponseFormatter::jsonResponse($data, $statusCode);
    }
}
