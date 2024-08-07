<?php

declare(strict_types=1);

namespace common\config\bootstrap;

use app\log\service\Log;
use app\routing\producers\ProducerContract;
use app\routing\producers\Rabbit;
use app\routing\producers\StaticProducer;
use Yii;
use yii\base\BootstrapInterface;
use yii\di\Container;

final class SetUp implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingletons([
            Log::class => static fn(Container $container, $params, $config) => new Log(Yii::getLogger()),
        ]);

        if (YII_ENV_PROD) {
            $container->setSingletons([
                ProducerContract::class => static fn(Container $container, $params, $config) => new Rabbit($app->rabbitmq->getProducer('main_producers')),

            ]);
        } elseif (YII_ENV_DEV) {
            $container->setSingletons([
                ProducerContract::class => static fn(Container $container, $params, $config) => new Rabbit(
                    $app->rabbitmq->getProducer('main_producers'),
                ),

            ]);
        } else {
            $container->setSingletons([
                ProducerContract::class => static fn(Container $container, $params, $config) => new StaticProducer(),

            ]);
        }
    }
}
