<?php

namespace app\application\command\check_tasks;

use app\base\entity\Status;
use app\base\factory\QueryFactory;
use Ramsey\Uuid\Uuid;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

readonly class Handler
{
    public function __construct(
        public QueryFactory $queryFactory,
    )
    {
    }

    public function handler(Command $command): array
    {
        $data = $this->queryFactory
            ->create()
            ->from('{{%tasks}}')
            ->andWhere(['id' => $command->id])
            ->one();

        if(empty($data)) {
            throw new \DomainException('Not found');
        }

        $dataParams = !empty($data['task_data']) ? Json::decode($data['task_data']) : [];


        return [
            'status' => Status::from($data['status'])->value,
            'paramsExecute' => ArrayHelper::getValue($dataParams, 'paramsExecute', []),
        ];
    }
}
