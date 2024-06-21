<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\Helper;

use PDOStatement;

class StatementHelper
{
    public function getSentSqlFromExecutedStatement(PDOStatement $executedStatement): ?string
    {
        ob_start();
        $executedStatement->debugDumpParams();
        $sqlPreparedCommand = ob_get_clean();
        $matches = [];
        $result = preg_match('/Sent\sSQL:\s\[\d+\]\s(.+)\n/', $sqlPreparedCommand, $matches);
        if ($result === false) {
            return null;
        }

        return $matches[1];
    }
}
