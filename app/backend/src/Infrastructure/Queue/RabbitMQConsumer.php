<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Queue;

use AnatolyShilyaev\Backend\Application\UseCase\ParseCourtCases\GetCourtCaseHtmlUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\ParseCourtCases\ParseCourtCaseFromHtmlUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\ParseCourtCases\ParseCourtCasesUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateCourtParseStatus\UpdateCourtParseStatusRequest;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateCourtParseStatus\UpdateCourtParseStatusUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateParsedCourtCase\UpdateParsedCourtCaseRequest;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateParsedCourtCase\UpdateParsedCourtCaseUseCase;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConsumer
{
    private AMQPStreamConnection $connection;
    private ParseCourtCasesUseCase $parseCourtCasesUseCase;


    public function __construct(
        private UpdateParsedCourtCaseUseCase $updateParsedCourtCaseUseCase,
        private UpdateCourtParseStatusUseCase $updateCourtParseStatusUseCase,
        private GetCourtCaseHtmlUseCase $getCourtCaseHtmlUseCase,
        private ParseCourtCaseFromHtmlUseCase $parseCourtCaseFromHtmlUseCase,
    ) {
        $this->connection = new AMQPStreamConnection(
            'rabbitmq',
            5672,
            'guest',
            'guest',
        );

        $this->parseCourtCasesUseCase = new ParseCourtCasesUseCase($this->getCourtCaseHtmlUseCase, $this->parseCourtCaseFromHtmlUseCase);
    }

    public function __invoke()
    {
        $channel = $this->connection->channel();

        $channel->queue_declare('parse_queue', false, true, false, false);

        echo "[*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            $id = json_decode($msg->body, true)['id'];
            $url = json_decode($msg->body, true)['url'];
            $parsedData = ($this->parseCourtCasesUseCase)($url);

            if ($parsedData['status'] === 'success') {
                $data = $parsedData['data'];
                $updateParsedCourtCaseRequest = new UpdateParsedCourtCaseRequest(
                    $id,
                    $data['courtTitle'],
                    $data['uid'],
                    $data['caseNumber'],
                    $data['judgeFio'],
                    $data['registerDate'],
                    $data['events'],
                    $data['parties'],
                );

                // Обновляем данные а базе
                ($this->updateParsedCourtCaseUseCase)($updateParsedCourtCaseRequest);
            }
            $updateCourtParseStatusRequest = new UpdateCourtParseStatusRequest(
                $id,
                $parsedData['status'],
                $parsedData['errorType'],
            );

            // Обновляем данные а базе
            ($this->updateCourtParseStatusUseCase)($updateCourtParseStatusRequest);

            echo $url . PHP_EOL;
            echo "[x] Received " . json_encode($parsedData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";

            // подтверждение после успешной обработки
            $msg->ack();
        };

        $channel->basic_qos(null, 1, null); // Обрабатывать по одному сообщению за раз
        $channel->basic_consume('parse_queue', '', false, false, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}
