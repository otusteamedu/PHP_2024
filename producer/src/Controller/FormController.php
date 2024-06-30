<?php

namespace Producer\Controller;

use Exception;
use Producer\Exception\ApplicationException;
use Producer\Exception\InvalidInputException;
use Producer\Exception\RabbitMQException;
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

    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->handlePostRequest();
            } catch (ApplicationException $e) {
                $this->render('form', ['error' => $e->getMessage()]);
            }
            $this->render('form', ['success' => 'Message sent to queue']);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->render('form');
        }
    }

    /**
     * @throws ApplicationException
     */
    private function handlePostRequest(): void
    {
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;
        $email = $_POST['email'] ?? null;

        try {
            $this->validateInput($startDate, $endDate, $email);
        } catch (InvalidInputException $e) {
            $this->logger->error('Invalid input', ['error' => $e->getMessage()]);
            throw $e;
        }

        try {
            $data = json_encode([
                'start_date' => $startDate,
                'end_date' => $endDate,
                'email' => $email,
            ], JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            $this->logger->error('Failed to encode data', ['error' => $exception->getMessage()]);
            throw $e;
        }

        try {
            $this->rabbitMQService->sendMessage($data);
        } catch (RabbitMQException $e) {
            $this->logger->error('Failed to send message', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * @throws InvalidInputException
     */
    private function validateInput(?string $startDate, ?string $endDate, ?string $email): void
    {
        if (empty($startDate)) {
            throw new InvalidInputException('start_date');
        }

        if (empty($endDate)) {
            throw new InvalidInputException('end_date');
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidInputException('email');
        }
    }

    private function render(string $view, array $data = []): void
    {
        require "../src/View/{$view}.php";
    }
}
