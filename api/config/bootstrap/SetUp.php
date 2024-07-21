<?php

declare(strict_types=1);

namespace api\config\bootstrap;


use app\application\form\AddTasksForm;
use app\application\form\CheckStatusForm;
use Yii;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;
        $request = $app->request;

        $container->setDefinitions([
            AddTasksForm::class => static fn () => AddTasksForm::loadForm($request->getQueryParams()),
            CheckStatusForm::class => static fn () => CheckStatusForm::loadForm($request->getQueryParams()),
        ]);
    }
}
