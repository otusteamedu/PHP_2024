<?php

declare(strict_types=1);

namespace app\base\factory;

use Yii;
use yii\db\Command;
use yii\db\Query;

/**
 * @codeCoverageIgnore
 */
class QueryFactory
{
    public function create(): Query
    {
        return new Query();
    }

    public function createCommand(?string $sql = null, array $params = []): Command
    {
        return Yii::$app->db->createCommand($sql, $params);
    }
}
