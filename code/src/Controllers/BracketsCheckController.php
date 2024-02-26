<?php

declare(strict_types=1);

namespace IGalimov\Hw41\Controllers;
/**
 * Class BracketsCheckController
 * @package Controllers
 */
class BracketsCheckController
{
    public function initApp()
    {
        try {
            $this->runApp();
        } catch (\Exception $e){
            http_response_code($e->getCode());
            echo $e->getMessage();
        }
    }

    /**
     * @throws \Exception
     */
    public function runApp(): void
    {
        if($_SERVER['REQUEST_METHOD'] !== "POST") {
            throw new \Exception('Неопределенный метод запроса', 405);
        }

        $requestBodyJson = file_get_contents('php://input');
        $requestBody = json_decode($requestBodyJson);

        if(!isset($requestBody->string)){
            throw new \Exception('Не указан параметр string в теле запроса', 422);
        }

        if(mb_strlen($requestBody->string) === 0){
            throw new \Exception('Параметр string пуст', 422);
        }

        if(!$this->checkStringBrackets($requestBody->string)){
            throw new \Exception('Строка в поле string некорректна', 400);
        }

        http_response_code(200);
        echo 'Успешно';
        return;
    }

    /**
     * @param string $string
     * @return bool
     */
    private function checkStringBrackets(string $string): bool
    {
        $regExp = '/^[^()\n]*+(\((?>[^()\n]|(?1))*+\)[^()\n]*+)++$/m';

        preg_match($regExp, $string, $matches);

        return count($matches) !== 0;
    }
}