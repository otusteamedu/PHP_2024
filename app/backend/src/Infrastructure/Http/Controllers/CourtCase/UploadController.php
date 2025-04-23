<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Http\Controllers\CourtCase;

use AnatolyShilyaev\Backend\Application\UseCase\GetAllCourtCases\GetAllCourtCasesUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\ParseCourtCases\ParseCourtCasesUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateCourtParseStatus\UpdateCourtParseStatusUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateParsedCourtCase\UpdateParsedCourtCaseUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateParseStatus\UpdateParseStatusRequest;
use AnatolyShilyaev\Backend\Application\UseCase\UpdateParseStatus\UpdateParseStatusUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\UploadCourtCases\UploadCourtCasesRequest;
use AnatolyShilyaev\Backend\Application\UseCase\UploadCourtCases\UploadCourtCasesUseCase;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class UploadController
{
    public function __construct(
        private UploadCourtCasesUseCase $uploadCourtCasesUseCase,
        private UpdateParsedCourtCaseUseCase $updateParsedCourtCaseUseCase,
        private UpdateCourtParseStatusUseCase $updateCourtParseStatusUseCase,
        private GetAllCourtCasesUseCase $getAllCourtCasesUseCase,
        private ParseCourtCasesUseCase $parseCourtCasesUseCase,
        private UpdateParseStatusUseCase $updateParseStatusUseCase,
    ) {
        // Empty constructor
    }
    public function __invoke()
    {
        try {
            // Получаем "сырое" тело запроса
            $input = file_get_contents('php://input');

            // Декодируем JSON в ассоциативный массив
            $requestData = json_decode($input, true)['data'];

            // Формируем DTO
            $uploadCourtCasesRequest = [];
            foreach ($requestData as $item) {
                $uploadCourtCasesRequest[] = new UploadCourtCasesRequest($item['generalNumber'], $item['url']);
            }

            // Загружаем данные а базу
            ($this->uploadCourtCasesUseCase)($uploadCourtCasesRequest);

            // Получаем загруженные данные
            $allCourtsCases = ($this->getAllCourtCasesUseCase)();

            // Обновляем статус
            $updateParseStatusRequest = new UpdateParseStatusRequest(true);
            ($this->updateParseStatusUseCase)($updateParseStatusRequest);

            // Устанавливаем соединение с RabbitMQ
            $connection = new AMQPStreamConnection(
                'rabbitmq',
                5672,
                'guest',
                'guest',
                // '/',              // Виртуальный хост RabbitMQ (по умолчанию "/")
                // false,            // Включить TLS (если требуется безопасное соединение)
                // true,            // Включить автоматическое восстановление соединений
                // 3600              // Это не "время жизни соединения", а параметр `heartbeat`, если передать 0, это отключает heartbeat
            );
            $channel = $connection->channel();

            // Создаём очередь, если она не существует
            $channel->queue_declare('parse_queue', false, true, false, false);
            $channel->confirm_select();
            $results = [];

            foreach ($allCourtsCases as $courtsCase) {
                try {
                    $id = $courtsCase->getId();
                    $url = $courtsCase->getUrl()->getValue();

                    // Создаём сообщение
                    $messageBody = json_encode([
                        'id' => $id,
                        'url' => $url,
                    ]);

                    if ($messageBody === false) {
                        throw new \Exception('Ошибка сериализации данных');
                    }

                    $message = new AMQPMessage($messageBody, [
                        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
                    ]);

                    // Отправляем сообщение в очередь
                    $channel->basic_publish($message, '', 'parse_queue');

                    error_log("№ сообщения:" . count($results) . PHP_EOL);
                    error_log("Сообщение отправлено в очередь: $messageBody");

                    $results[] = [
                        'id' => $id,
                        'url' => $url,
                        'success' => true,
                        'message' => 'Добавлено в очередь',
                    ];
                } catch (\Throwable $e) {
                    error_log('Ошибка при отправке в очередь: ' . $courtsCase->getUrl()->getValue() . ' - ' . $e->getMessage());

                    $results[] = [
                        'url' => $courtsCase->getUrl()->getValue(),
                        'success' => false,
                        'error' => $e->getMessage(),
                    ];
                }
            }

            // Устанавливаем обработчик для подтверждения сообщений
            $channel->set_ack_handler(function (AMQPMessage $message) {
                error_log("Сообщение подтверждено: " . json_encode($message->getBody()));
            });

            // Устанавливаем обработчик для отклонения сообщений (NACK)
            $channel->set_nack_handler(function (AMQPMessage $message) {
                error_log("Сообщение отклонено (NACK): " . json_encode($message->getBody()));
            });

            usleep(1000000);

            $channel->wait_for_pending_acks();

            $channel->close();
            $connection->close();

            return [
                'message' => 'Загрузка завершена, ссылки добавлены в очередь',
                'results' => $results,
            ];
        } catch (\Throwable $e) {
            error_log('Критическая ошибка в UploadCourtCasesController' . $e->getMessage());
            return [
                'error' => 'Ошибка на сервере: ' . $e->getMessage(),
            ];
        }
    }
}
