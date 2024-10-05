<?php

declare(strict_types=1);

namespace Evgenyart\Hw13;

use Exception;

class App
{
    public function run()
    {
        #new DBConnection();
        $args = $_SERVER['argv'];

        $ExceptionError = "Необходимо ввести параметр `insert`, `select`, `selectall`, `update`  либо `delete`";

        if (!isset($args[1])) {
            throw new Exception($ExceptionError);
        }

        $runCommand = new RunCommand();

        switch ($args[1]) {
            case 'insert':
                $runCommand->insertData($args);
                break;
            case 'selectall':
                $runCommand->selectAllData();
                break;
            case 'select':
                $runCommand->selectData($args);
                break;
            case 'update':
                $runCommand->updataData($args);
                break;
            case 'delete':
                $runCommand->deleteData($args);
                break;
            default:
                throw new Exception($ExceptionError);
                break;
        }
    }
}
