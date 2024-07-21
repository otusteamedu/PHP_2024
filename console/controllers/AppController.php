<?php

declare(strict_types=1);

namespace console\controllers;

use RuntimeException;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 *
 * @property mixed $executable
 * @property mixed $writable
 */
class AppController extends Controller
{
    public array $writablePaths = [
        '@common/runtime',
        '@console/runtime',
        '@backend/web/assets',
    ];

    public array $executablePaths = [
        '@console/yii',
    ];

    public array $generateKeysPaths = [
        '@base/.env',
    ];

    public function actionSetup(): void
    {
        $this->runAction('set-writable', ['interactive' => $this->interactive]);
        $this->runAction('set-executable', ['interactive' => $this->interactive]);

        Yii::$app->runAction('migrate/up', ['interactive' => $this->interactive]);
        Yii::$app->runAction('rbac-migrate/up', ['interactive' => $this->interactive]);
    }

    public function actionSetWritable(): void
    {
        $this->setWritable($this->writablePaths);
    }

    public function actionSetExecutable(): void
    {
        $this->setExecutable($this->executablePaths);
    }

    public function setWritable($paths): void
    {
        foreach ($paths as $writable) {
            $writable = Yii::getAlias($writable);
            Console::output("Setting writable: {$writable}");

            if (!is_dir($writable)) {
                if (!mkdir($writable, 0o777, true) && !is_dir($writable)) {
                    throw new RuntimeException(sprintf('Directory "%s" was not created', $writable));
                }
            } else {
                @chmod($writable, 0o777);
            }
        }
    }

    public function setExecutable($paths): void
    {
        foreach ($paths as $executable) {
            $executable = Yii::getAlias($executable);
            Console::output("Setting executable: {$executable}");
            @chmod($executable, 0o755);
        }
    }
}
