<?php

namespace Producer\Controller;

use Exception;
use Producer\Service\RabbitMQService;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class FormController
{
    private RabbitMQService $rabbitMQService;
    private LoggerInterface $logger;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $host = getenv('RABBITMQ_HOST');
        $port = getenv('RABBITMQ_PORT');
        $user = getenv('RABBITMQ_USER_NAME');
        $password = getenv('RABBITMQ_PASSWORD');
        $this->logger = new NullLogger();

        $this->rabbitMQService = new RabbitMQService($host, $port, $user, $password, $this->logger);
    }

    public function handleSubmit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $startDate = $_POST['start_date'] ?? null;
            $endDate = $_POST['end_date'] ?? null;
            $email = $_POST['email'] ?? null;

            if (!$this->validateInput($startDate, $endDate, $email)) {
                $this->logger->error('Invalid input data', ['start_date' => $startDate, 'end_date' => $endDate, 'email' => $email]);
                exit('Невалидные данные');
            }

            try {
                $data = json_encode([
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'email' => $email,
                ], JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                $this->logger->error('JSON encoding error', ['error' => $e->getMessage()]);
                exit('Ошибка при кодировании данных в JSON');
            }

            try {
                $this->rabbitMQService->sendMessage($data);
            } catch (Exception $e) {
                $this->logger->error('Failed to send message', ['error' => $e->getMessage()]);
                exit('Ошибка при отправке сообщения');
            }
        }
    }

    private function validateInput(?string $startDate, ?string $endDate, ?string $email): bool
    {
        if (empty($startDate) || empty($endDate) || empty($email)) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}