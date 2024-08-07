<?php

declare(strict_types=1);

namespace common\config\bootstrap;

use mikemadisonweb\rabbitmq\components\Consumer;
use mikemadisonweb\rabbitmq\components\ConsumerInterface;
use mikemadisonweb\rabbitmq\components\Logger;
use mikemadisonweb\rabbitmq\components\Routing;
use mikemadisonweb\rabbitmq\Configuration;
use mikemadisonweb\rabbitmq\exceptions\InvalidConfigException;
use PhpAmqpLib\Connection\AbstractConnection;
use Yii;

class DependencyInjection extends \mikemadisonweb\rabbitmq\DependencyInjection
{
    protected function registerConsumers(Configuration $config): void
    {
        $autoDeclare = $config->auto_declare;
        foreach ($config->consumers as $options) {
            $serviceAlias = sprintf(Configuration::CONSUMER_SERVICE_NAME, $options['name']);
            Yii::$container->setSingleton($serviceAlias, function () use ($options, $autoDeclare) {
                /**
                 * @var AbstractConnection $connection
                 */
                $connection = Yii::$container->get(sprintf(Configuration::CONNECTION_SERVICE_NAME, $options['connection']));
                /**
                 * @var Routing $routing
                 */
                $routing = Yii::$container->get(Configuration::ROUTING_SERVICE_NAME, ['conn' => $connection]);
                /**
                 * @var Logger $logger
                 */
                $logger = Yii::$container->get(Configuration::LOGGER_SERVICE_NAME);
                $consumer = new Consumer($connection, $routing, $logger, (bool)$autoDeclare);
                $queues = [];
                foreach ($options['callbacks'] as $queueName => $callback) {
                    $callbackClass = $this->getCallbackClass($callback);
                    $queues[$queueName] = [$callbackClass, 'execute'];
                }
                Yii::$container->invoke([$consumer, 'setName'], [$options['name']]);
                Yii::$container->invoke([$consumer, 'setQueues'], [$queues]);
                Yii::$container->invoke([$consumer, 'setQos'], [$options['qos']]);
                Yii::$container->invoke([$consumer, 'setIdleTimeout'], [$options['idle_timeout']]);
                Yii::$container->invoke([$consumer, 'setIdleTimeoutExitCode'], [$options['idle_timeout_exit_code']]);
                Yii::$container->invoke([$consumer, 'setProceedOnException'], [$options['proceed_on_exception']]);
                Yii::$container->invoke([$consumer, 'setDeserializer'], [$options['deserializer']]);

                return $consumer;
            });
        }
    }

    private function getCallbackClass(string $callbackName): ConsumerInterface
    {
        if (!class_exists($callbackName)) {
            $callbackClass = Yii::$container->get($callbackName);
        } else {
            $callbackClass = Yii::createObject($callbackName);
        }
        if (!$callbackClass instanceof ConsumerInterface) {
            throw new InvalidConfigException("{$callbackName} should implement ConsumerInterface.");
        }

        return $callbackClass;
    }
}
