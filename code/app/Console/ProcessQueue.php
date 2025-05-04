<?php

namespace App\Console;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Console\Command;
use App\Repositories\Request\RequestEloquentRepository;

class ProcessQueue extends Command
{
    protected $signature = 'queue:process';
    protected $description = 'Process messages from the request queue';

    public function handle()
    {
        $connection = new AMQPStreamConnection('otus-rabbit-mq', 5672, 'user', 'password');
        $channel = $connection->channel();
        $channel->queue_declare('request_queue', false, true, false, false, false, []);

        $callback = function (AMQPMessage $msg) {
            $data = json_decode($msg->body, true);
            $id = $data['id'];
            sleep(5);
            echo "Processed request ID: $id\n";
            $new = new RequestEloquentRepository();
            $new->update($id, 'complited');
        };

        $channel->basic_consume('request_queue', '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
