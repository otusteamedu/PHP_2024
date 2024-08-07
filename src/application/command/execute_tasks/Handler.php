<?php

namespace app\application\command\execute_tasks;

use app\base\entity\Status;
use app\base\factory\QueryFactory;
use Ramsey\Uuid\Uuid;
use yii\helpers\Json;

readonly class Handler
{
    public function __construct(
        public QueryFactory $queryFactory,
    )
    {
    }

    public function handler(Command $command): bool
    {
        $data = $this->queryFactory
            ->create()
            ->from('{{%tasks}}')
            ->andWhere(['id' => $command->id])
            ->one();

        if (empty($data)) {
            throw new \DomainException('Not found');
        }

        $dataParams = !empty($data['task_data']) ? Json::decode($data['task_data']) : [];
        $dataParams['paramsExecute'] = $command->data;

        $this->queryFactory
            ->createCommand()
            ->update('{{%tasks}}', [
                'task_data' => $dataParams,
                'status' => Status::Success->value,
                'updated_at' => time(),
            ], ['id' => $command->id])
            ->execute();

        return true;
    }
}
