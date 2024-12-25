<?php

namespace PaymentServiceBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class PaymentServiceBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yaml');
    }

    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $builder->prependExtensionConfig(
            'doctrine',
            [
                'orm' => [
                    'mappings' => [
                        'PaymentServiceBundle' => [
                            'type' => 'attribute',
                            'dir' => '%kernel.project_dir%/paymentServiceBundle/src/Domain/Entity',
                            'prefix' => 'PaymentServiceBundle\Domain\Entity',
                            'alias' => 'PaymentServiceBundle'
                        ]
                    ]
                ]
            ]
        );

        $builder->prependExtensionConfig(
            'twig',
            [
                'paths' => [
                        '%kernel.project_dir%/paymentServiceBundle/templates' => 'paymentServiceBundle',
                ]
            ]
        );

        $builder->prependExtensionConfig(
            'old_sound_rabbit_mq',
            [
                'producers' => [
                    'payment_service_payment_create' => [
                        'connection' => 'default',
                        'exchange_options' => ['name' => 'old_sound_rabbit_mq.payment_service_payment_create', 'type' => 'direct'],
                    ],
                    'payment_service_payment_update' => [
                        'connection' => 'default',
                        'exchange_options' => ['name' => 'old_sound_rabbit_mq.payment_service_payment_update', 'type' => 'direct'],
                    ],
                    'payment_service_payment_delete' => [
                        'connection' => 'default',
                        'exchange_options' => ['name' => 'old_sound_rabbit_mq.payment_service_payment_delete', 'type' => 'direct'],
                    ],
                    'payment_service_report_create' => [
                        'connection' => 'default',
                        'exchange_options' => ['name' => 'old_sound_rabbit_mq.payment_service_report_create', 'type' => 'direct'],
                    ],
                    'payment_service_send_email' => [
                        'connection' => 'default',
                        'exchange_options' => ['name' => 'old_sound_rabbit_mq.payment_service_send_email', 'type' => 'direct'],
                    ],
                ],
                'consumers' => [
                    'payment_service_payment_create' => [
                        'connection' => 'default',
                        'exchange_options' => ['name' => 'old_sound_rabbit_mq.payment_service_payment_create', 'type' => 'direct'],
                        'queue_options' => [ 'name' => 'old_sound_rabbit_mq.payment_service_payment_create' ],
                        'callback' => Controller\Amqp\Payment\Create\Consumer::class,
                        'idle_timeout' => 300,
                        'idle_timeout_exit_code' => 0,
                        'graceful_max_execution' => ['timeout' => 1800, 'exit_code' => 0],
                        'qos_options' => ['prefetch_size' => 0, 'prefetch_count' => 1, 'global' => false],
                    ],
                    'payment_service_payment_update' => [
                        'connection' => 'default',
                        'exchange_options' => ['name' => 'old_sound_rabbit_mq.payment_service_payment_update', 'type' => 'direct'],
                        'queue_options' => [ 'name' => 'old_sound_rabbit_mq.payment_service_payment_update' ],
                        'callback' =>  Controller\Amqp\Payment\Update\Consumer::class,
                        'idle_timeout' => 300,
                        'idle_timeout_exit_code' => 0,
                        'graceful_max_execution' => ['timeout' => 1800, 'exit_code' => 0],
                        'qos_options' => ['prefetch_size' => 0, 'prefetch_count' => 1, 'global' => false],
                    ],
                    'payment_service_payment_delete' => [
                        'connection' => 'default',
                        'exchange_options' => ['name' => 'old_sound_rabbit_mq.payment_service_payment_delete', 'type' => 'direct'],
                        'queue_options' => [ 'name' => 'old_sound_rabbit_mq.payment_service_payment_delete' ],
                        'callback' =>  Controller\Amqp\Payment\Delete\Consumer::class,
                        'idle_timeout' => 300,
                        'idle_timeout_exit_code' => 0,
                        'graceful_max_execution' => ['timeout' => 1800, 'exit_code' => 0],
                        'qos_options' => ['prefetch_size' => 0, 'prefetch_count' => 1, 'global' => false],
                    ],
                    'payment_service_report_create' => [
                        'connection' => 'default',
                        'exchange_options' => ['name' => 'old_sound_rabbit_mq.payment_service_report_create', 'type' => 'direct'],
                        'queue_options' => [ 'name' => 'old_sound_rabbit_mq.payment_service_report_create' ],
                        'callback' =>  Controller\Amqp\Report\Create\Consumer::class,
                        'idle_timeout' => 300,
                        'idle_timeout_exit_code' => 0,
                        'graceful_max_execution' => ['timeout' => 1800, 'exit_code' => 0],
                        'qos_options' => ['prefetch_size' => 0, 'prefetch_count' => 1, 'global' => false],
                    ],
                    'payment_service_send_email' => [
                        'connection' => 'default',
                        'exchange_options' => ['name' => 'old_sound_rabbit_mq.payment_service_send_email', 'type' => 'direct'],
                        'queue_options' => [ 'name' => 'old_sound_rabbit_mq.payment_service_send_email' ],
                        'callback' =>  Controller\Amqp\Mailer\Consumer::class,
                        'idle_timeout' => 300,
                        'idle_timeout_exit_code' => 0,
                        'graceful_max_execution' => ['timeout' => 1800, 'exit_code' => 0],
                        'qos_options' => ['prefetch_size' => 0, 'prefetch_count' => 1, 'global' => false],
                    ],
                ]
            ]
        );
    }
}
