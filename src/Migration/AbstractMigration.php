<?php

declare(strict_types=1);

namespace App\Migration;

use App\Provider\DatabaseProviderInterface;

abstract class AbstractMigration
{
    protected DatabaseProviderInterface $databaseProvider;
    public function __construct(DatabaseProviderInterface $databaseProvider)
    {
        $this->databaseProvider = $databaseProvider;
    }
    abstract public function up(): void;
    abstract public function down(): void;
}
