<?php
declare(strict_types=1);

namespace App\Infrastructure\Consumer;

use App\Application\UseCase\GetStatementUseCase\GetStatementRequest;
use App\Application\UseCase\GetStatementUseCase\GetStatementUseCase;
use App\Application\UseCase\SendStatementUseCase\SendStatementRequest;
use App\Application\UseCase\SendStatementUseCase\SendStatementUseCase;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

final class StatementConsumer implements ConsumerInterface
{
    public function __construct(
        private GetStatementUseCase $getStatementUseCase,
        private SendStatementUseCase $sendStatementUseCase
    ) {
    }

    public function execute(AMQPMessage $msg): bool
    {
        try {
            $msg = json_decode($msg->getBody());
            $request = new GetStatementRequest($msg->statementId);
            echo "Generating Statement " . $msg->statementId . PHP_EOL;
            echo "Sending Statement" . PHP_EOL;
            $statement = ($this->getStatementUseCase)($request)->statement;
            $result = ($this->sendStatementUseCase)(new SendStatementRequest($statement))->result;
            if ($result) {
                echo 'Statement send ' . $msg->statementId . PHP_EOL;
            }
            return $result;
        } catch (\Exception $exception) {
            echo "Error sending statement" . $exception->getMessage() . PHP_EOL;
            return false;
        } catch (TransportExceptionInterface $e) {
            echo "Error sending statement" . $e->getMessage() . PHP_EOL;
            return false;
        }
    }
}
