<?php
declare(strict_types=1);


namespace App\Infrastructure\Http;


use App\Application\UseCase\AddStReqToQueueUseCase\AddStReqToQueueUseCase;
use App\Domain\Entity\StatementRequest;
use App\Domain\ValueObject\Dates;
use App\Infrastructure\Queue\RabbitMQ;
use Exception;

class Controller
{

    /**
     * @throws Exception
     */
    public function run(): string
    {
        if (
            array_key_exists('date_from', $_POST) &&
            array_key_exists('date_to', $_POST)
        ) {
            $date_from = $_POST['date_from'];
            $date_to = $_POST['date_to'];
        } else {
            http_response_code(400);
            return 'Параметры POST не переданы';
        }
        $statementRequest = new StatementRequest(new Dates($date_from, $date_to));
        $queueBroker = new RabbitMQ(
            getenv('RABBITMQ_HOST'),
            getenv('RABBITMQ_PORT'),
            getenv('RABBITMQ_USER'),
            getenv('RABBITMQ_PASSWORD')
        );
        $addStReqToQueueUseCase = new AddStReqToQueueUseCase($statementRequest, $queueBroker);
        return $addStReqToQueueUseCase();
    }
}