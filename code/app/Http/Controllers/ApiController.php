<?php

namespace App\Http\Controllers;



use Amqp;
use App\Models\QueueWork;
use Laravel\Lumen\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    public function someWork()
    {
        $requestContent = json_decode(request()->getContent());
        if(isset($requestContent->data) && !empty($requestContent->data)) {
            $data = $requestContent->data;
        } else {
            return response()->json(['error' => 'Invalid input data.'])->setStatusCode(400);
        }

        $work = new QueueWork();
        $work->status = 'not processed';
        $work->save();

        $message = [
            'id' => $work->id,
            'body' => $data
        ];

        Amqp::publish('routing-key', json_encode($message), ['queue' => 'queue01']);

        return response()->json(['id' => $work->id])->setStatusCode(200);

    }

    public function checkStatus()
    {
        $id = request()->query('id');

        if(empty($id) || !is_numeric($id)) {
            return response()->json(['error' => 'Invalid request ID.'])->setStatusCode(400);
        }

        $queueWork = QueueWork::find($id);
        if (is_null($queueWork)) {
            return response()->json(['error' => 'Request not found.'])->setStatusCode(400);
        }
        return $queueWork->status;
    }
}
