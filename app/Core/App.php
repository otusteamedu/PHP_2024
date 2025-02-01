<?php

namespace Core;

class App
{
    public static array $params = [];

    public function run()
    {
        $args = $_SERVER['argv'];
        $params = $args[2] ?? null;

        switch ($args[1]) {
            case "setRequest": // php index.php setRequest '{"user_id":1, "inn": "1207700296473"}'
                $this->helper_setRequest($params);
                break;
            case "getResult":
                $this->helper_getResult($params); // php index.php getResult '{"message_id": "2bf32adf274fdccc6bacdeb5af5a7116"}'
                break;
            case "prepare":
                $this->helper_prepare();
                break;
            default:
                throw new \Exception('command not found');
                break;
        }
    }

    private function helper_setRequest(string $params)
    {
        $params = json_decode($params, true);
        $Publisher = new \Src\Infrastructure\Utils\Publisher();
        $Redis = new \Src\Infrastructure\Gateway\RedisGateway();
        $UseCase = new \Src\Application\UseCase\SubmitCounterparty\SubmitCounterpartyUseCase($Publisher, $Redis);
        $Command = new \Src\Infrastructure\Command\SubmitCounterpartyCommand($UseCase);
        $Request = new \Src\Application\UseCase\SubmitCounterparty\SubmitCounterpartyRequest($params['user_id'], $params['inn']);
        $result = $Command($Request);
        echo "message_id: " . $result->id . PHP_EOL;
    }

    private function helper_getResult(string $params)
    {
        $params = json_decode($params, true);
        $Redis = new \Src\Infrastructure\Gateway\RedisGateway();
        $UseCase = new \Src\Application\UseCase\GetCounterparty\GetCounterpartyUseCase($Redis);
        $Command = new \Src\Infrastructure\Command\GetCounterpartyCommand($UseCase);
        $Request = new \Src\Application\UseCase\GetCounterparty\GetCounterpartyRequest($params['message_id']);
        $result = $Command($Request);
        echo "status_id: " . $result->status_id . PHP_EOL . "result: " . json_encode($result->result) . PHP_EOL;
    }

    private function helper_prepare()
    {
        $Consumer = new \Src\Infrastructure\Utils\Consumer();
        $Redis = new \Src\Infrastructure\Gateway\RedisGateway();
        $UseCase = new \Src\Application\UseCase\PrepareCounterparty\PrepareCounterpartyUseCase($Consumer, $Redis);
        $Command = new \Src\Infrastructure\Command\PrepareCounterpartyCommand($UseCase);
        $Request = new \Src\Application\UseCase\PrepareCounterparty\PrepareCounterpartyRequest();
        $Command($Request);
    }
}