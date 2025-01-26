<?php
namespace Core;

use Symfony\Component\HttpFoundation\Request;

class App
{
    public function run()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $app = new \Silex\Application();

            $app->post('/api/v1/bank/statement/get', function (Request $request) use ($app) {

            });

        } else {
            $args = $_SERVER['argv'];

            if (isset($args[2]) && empty($params = json_decode($args[2], true))) {
                throw new \Exception('second params only json');
            }

            switch ($args[1]) {
                case "statement_set": // php index.php statement_set '{"user_id":1, "from_date": "01.01.2025", "to_date": "20.01.2025"}'
                    $this->helper_statementGet($params);
                    break;
                case "statement": // php index.php statement
                    $this->helper_statement();
                    break;
                default:
                    throw new \Exception('command not found');
                    break;
            }

            var_dump($args);
            var_dump($params);
            exit;
        }
    }

    private function helper_statementGet(array $params)
    {
        $Repository = new \Src\Infrastructure\Repository\UserRepository();
        $Publisher = new \Src\Infrastructure\Utils\Publisher();
        $UseCase = new \Src\Application\UseCase\SetStatement\SetStatementUseCase($Publisher, $Repository);
        $Command = new \Src\Infrastructure\Command\SetStatementCommand($UseCase);
        $Request = new \Src\Application\UseCase\SetStatement\SetStatementRequest($params['user_id'], $params['from_date'], $params['to_date']);
        $result = $Command($Request);
    }

    private function helper_statement()
    {
        $Consumer = new \Src\Infrastructure\Utils\Consumer();
        $Repository = new \Src\Infrastructure\Repository\TransactionRepository();
        $UseCase = new \Src\Application\UseCase\MakeStatement\MakeStatementUseCase($Consumer, $Repository);
        $Command = new \Src\Infrastructure\Command\MakeStatementCommand($UseCase);
        $Request = new \Src\Application\UseCase\MakeStatement\MakeStatementRequest();
        $result = $Command($Request);
    }
}