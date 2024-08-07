<?php

declare(strict_types=1);

namespace api\components;

use api\entity\ResultEntity;
use yii\base\Model;
use yii\web\Response;

class ApiSerializer
{
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param $data
     */
    public function serialize($data): mixed
    {
        if ($data instanceof ResultEntity) {
            $data = $this->serializeResultEntity($data);
        }
        return $data;
    }

    private function serializeResultEntity(ResultEntity $resultEntity): mixed
    {
        if ($resultEntity->hasError()) {
            $this->response->setStatusCode(422, 'Data Validation Failed.');
            $result = [];
            foreach ($resultEntity->getFirstErrors() as $name => $message) {
                $result[] = [
                    'field' => $name,
                    'message' => $message,
                ];
            }

            return $result;
        }
        if ($resultEntity->getResult() instanceof Model) {
            return $resultEntity->getResult()->toArray();
        }
        return $resultEntity->getResult();
    }
}
