<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\UseCase\SubmitStatementRequest;
use App\Infrastructure\Services\RabbitMQService;
use App\Infrastructure\Helpers\LoadConfig;
use App\Infrastructure\Services\GenerateBankStatementService;
use App\Infrastructure\Services\NotificationService;

class App
{
    public function run()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_REQUEST['account']) && isset($_REQUEST['dateFrom']) && isset($_REQUEST['dateTo'])) {
                    $request = new SubmitStatementRequest(
                        trim($_REQUEST['account']),
                        trim($_REQUEST['dateFrom']),
                        trim($_REQUEST['dateTo']),
                        date('Y-m-d H:i:s'),
                        (isset($_REQUEST['email']) ? $_REQUEST['email'] : "")
                    );

                    $rabbit = $this->initRabbit();
                    $rabbit->addMessage($request);
                    return print_r("Request accepted for processing");
                }
            }
        } elseif (isset($_SERVER['argv'][1])) {
            if ($_SERVER['argv'][1] == 'consumer') {
                $rabbit = $this->initRabbit();

                $callback = function ($msg) {
                    $body = $msg->body;
                    print_r('Received ' . $msg->body . PHP_EOL);
                    
                    $decodeData = json_decode($body, true);

                    if (isset($decodeData['email'])) {
                        $data = (new GenerateBankStatementService())->generate($decodeData);
                        (new NotificationService())->send($data);
                    }
                    $msg->ack();
                };

                $rabbit->getMessage($callback);
            }
        }
    }

    private function initRabbit()
    {
        $config = new LoadConfig();
        $rabbit = new RabbitMQService($config);
        return $rabbit;
    }
}
