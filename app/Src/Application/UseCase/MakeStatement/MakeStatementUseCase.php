<?php

namespace Src\Application\UseCase\MakeStatement;

use Src\Domain\Interface\ConsumerInterface;
use Src\Domain\Repository\TransactionRepositoryInterface;

class MakeStatementUseCase
{
    private ConsumerInterface $consumer;
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct(ConsumerInterface $consumer, TransactionRepositoryInterface $transactionRepository)
    {
        $this->consumer = $consumer;
        $this->transactionRepository = $transactionRepository;
    }

    public function __invoke(MakeStatementRequest $request): MakeStatementResponse
    {
        $callback = function ($msg) {
            $params = json_decode($msg->body, true);
            $from_date = new \DateTime($params['from_date']);
            $to_date = new \DateTime($params['to_date']);

            $period = new \DatePeriod($from_date, \DateInterval::createFromDateString('1 day'), $to_date);

            $ans = [];
            foreach ($period AS $date) {
                $transactions = $this->transactionRepository->findByDateAndUserId($params['user_id'], $date);
                foreach ($transactions ?? [] AS $item) {
                    $ans[] = [
                        'date' => $date->format('d.m.Y'),
                        'id' => $item['id']
                    ];
                }
            }

            if (!empty($ans)) {
                $message = 'Выписка за период с '.$from_date->format('d.m.Y'). ' по '.$to_date->format('d.m.Y') . ' кол-во транзакций: '. count($ans);
            } else {
                $message = 'Транзакций за данный период не найдено';
            }
            $message .= PHP_EOL;

            // sendEmail
            echo $params['email'] . $message;
        };
        $this->consumer->exec('statement', $callback);
        return new MakeStatementResponse();
    }
}