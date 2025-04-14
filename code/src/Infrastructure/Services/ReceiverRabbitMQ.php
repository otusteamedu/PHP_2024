<?php
declare(strict_types=1);

namespace App\Infrastructure\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;


class ReceiverRabbitMQ
{
    private string $queue = 'email_queue';

    public function __construct(){
        $config = ROOT .'/config/config.php';
        include($config);
    }

    public function execute()
    {
        $connection = new AMQPStreamConnection(HOST,PORT,USER,PASS);
        $channel = $connection->channel();

        $channel->queue_declare($this->queue, false, true, false, false);

        //$channel->basic_qos(null,1,null);

        echo "<br> * Waiting for messages<br>";

        $callback = function($msg){

            echo " * Message received<br>";
            $data = json_decode($msg->body, true);


            $firstname = $data['firstname'];
            $phone = $data['phone'];
            $email = $data['email'];
            $date1 = $data['date1'];
            $date2 = $data['date2'];

            echo " * Message was sent<br>";

            $token = '7573474114:AAGkpSE5evTpiAdQV7vkk1SAmy8x7uEN3AI';
            $telegram_admin_id = '1266166102';

            //Telegram bot
            $msg = "Ваша заявка на выписку из банка принята! \n\nE-mail: {$email} \nТелефон: {$phone} \nИмя: {$firstname} \n\nВыписка от: {$date1}\nдо: {$date2}";
            file_get_contents('https://api.telegram.org/bot'. $token .'/sendMessage?chat_id='. $telegram_admin_id .'&text=' . urlencode($msg));

        };

        //$channel->basic_qos(null, 1, null);
        $channel->basic_consume('email_queue', '', false, false, false, false, $callback);

        while(count($channel->callbacks)){
            $channel->wait();
        }

        $channel->close();
        $connection->close();

    }

}