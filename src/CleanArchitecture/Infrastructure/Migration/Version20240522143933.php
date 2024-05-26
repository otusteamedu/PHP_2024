<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20240522143933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create news table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('news');
        $table->addColumn('id', Types::INTEGER, ['autoincrement' => true]);
        $table->addColumn('created_at', Types::DATETIMETZ_IMMUTABLE, [
            'notnull' => true,
            'default' => 'CURRENT_TIMESTAMP',
        ]);
        $table->addColumn('url', Types::TEXT, ['notnull' => true]);
        $table->addColumn('title', Types::STRING, ['length' => 255]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['url'], 'news__url__unique');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('news');
    }
}
