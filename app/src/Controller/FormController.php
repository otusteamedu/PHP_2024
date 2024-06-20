<?php

declare(strict_types=1);

namespace Orlov\Otus\Controller;

use Orlov\Otus\Producer\RabbitMqProducer;
use Orlov\Otus\Render\FormRender;
use Orlov\Otus\Render\FormSuccessRender;

class FormController
{
    public function main(): void
    {
        echo (new FormRender())->show();
    }

    public function formHandler(): void
    {
        if (!empty($_REQUEST['send']) && !empty($_REQUEST['date_from'])) {
            $message = 'Date from: ' . $_REQUEST['date_from'] . ' Date to: ' . $_REQUEST['date_to'];
            (new RabbitMqProducer(new $_ENV['BROKER_CONNECT']()))
                ->send($message);
            echo (new FormSuccessRender())->show();
        }
    }
}
