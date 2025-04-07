<?php

declare(strict_types=1);

namespace SergeyShirykalov\HomeworkRabbit;

use SergeyShirykalov\HomeworkRabbit\Application\UseCase\SendUserRequest\SendBankRequestRequest;
use SergeyShirykalov\HomeworkRabbit\Application\UseCase\SendUserRequest\SendBankRequestUseCase;
use SergeyShirykalov\HomeworkRabbit\Infrastructure\AsyncHandler\RabbitHandler;
use SergeyShirykalov\HomeworkRabbit\Infrastructure\RabbitClient;

class App
{
    public static function run(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo file_get_contents('../src/Infrastructure/View/request_page.html');

        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rabbitClient = new RabbitClient($_ENV['RABBIT_QUEUE_NAME']);
            $rabbitHandler = new RabbitHandler($rabbitClient);
            $sendUserRequestUseCase = new SendBankRequestUseCase($rabbitHandler);
            $sendUserRequestRequest = new SendBankRequestRequest(
                $_REQUEST['user_name'],
                $_REQUEST['email'],
                $_REQUEST['data']
            );
            ($sendUserRequestUseCase)($sendUserRequestRequest);
            return 'The message sent';
        } else {
            return 'Invalid http method';
        }
        return '';
    }
}