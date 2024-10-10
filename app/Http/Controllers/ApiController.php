<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Jobs\ProcessRequestJob;

class ApiController extends Controller
{
    public function enqueueRequest(Request $request)
    {
        $requestId = uniqid();

        Redis::set('request_status:' . $requestId, 'queued');

        ProcessRequestJob::dispatch($requestId);

        return response()->json(['request_id' => $requestId]);
    }

    public function checkStatus($requestId)
    {
        $status = Redis::get('request_status:' . $requestId);

        return response()->json(['status' => $status ?? 'not found']);
    }
}
