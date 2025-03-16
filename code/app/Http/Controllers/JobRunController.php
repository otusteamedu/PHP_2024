<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Amqp;
use App\Models\QueueWork;
use Laravel\Lumen\Routing\Controller as BaseController;

class JobRunController extends BaseController
{
    public function run()
    {
        Amqp::consume('queue01', function ($message, $resolver) {
            $job = json_decode($message->body);
            $queueWork = QueueWork::find($job->id);
            $queueWork->status = 'completed';
            $queueWork->save();
            print 'Обработан id = ' . $job->id . PHP_EOL;
            print 'с содержанием: ' . $job->body . PHP_EOL;
            print PHP_EOL;
            $resolver->acknowledge($message);
            $resolver->stopWhenProcessed();
        });
    }
}
