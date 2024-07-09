<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateApiRequestsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('api_requests');
        $table->addColumn('body', 'string', ['null' => false])
            ->addColumn('status', 'string', ['limit' => 255, 'null' => false])
            ->create();
    }
}
