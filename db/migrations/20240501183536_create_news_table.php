<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateNewsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('news');
        $table->addColumn('url', 'string', ['limit' => 255])
            ->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('date', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
