<?php

namespace App\Http\Controllers;
use App\Models\Order; 
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Jobs\OrderJob;

class OrderController extends Controller
{
    public function show($id)
    {
        return response(Order::findOrFail($id));
        
        //Или по простому
        //$order = Order::find($id);
        //if($order) return $order->status;
        //else return 'Order not found';
    }

    public function add(){
        $order = new Order();
        $order->name = "test";
        $order->status = "created";
        $order->uuid = Str::uuid()->toString();
        $order->save();

        $id = $order->id;
        dispatch(new OrderJob($id));
        return $id;
    }
}