<?php

namespace app\application\command\add_tasks;

use app\base\entity\Status;
use app\base\factory\QueryFactory;
use app\routing\entity\Queues;
use app\routing\producers\ProducerContract;
use Ramsey\Uuid\Uuid;

readonly class Handler
{
    public function __construct(
        public QueryFactory     $queryFactory,
        public ProducerContract $contract
    )
    {
    }

    public function handler(Command $command): string
    {
        $id = Uuid::uuid4()->toString();
        $this->queryFactory
            ->createCommand()
            ->insert('{{%tasks}}', [
                'id' => $id,
                'task_data' => [
                    'phone' => $command->phone
                ],
                'status' => Status::Active->value,
                'created_at' => time(),
                'updated_at' => time(),
            ])->execute();

        $this->contract->publish(['id' => $id], Queues::ExecuteTasks->queuesName());

        return $id;
    }
}
