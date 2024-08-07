<?php

declare(strict_types=1);

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M211208131738Init.
 */
class M211208131738Init extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->string(36)->notNull(),
            'task_data' => $this->json()->defaultExpression('(JSON_OBJECT())'),
            'status' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('add_pk', '{{%tasks}}', 'id');

        return true;
    }

    public function safeDown()
    {
        $this->dropTable('{{%tasks}}');

        return true;
    }
}
