<?php

namespace App\Jobs;
use App\Models\Order;

class OrderJob extends Job
{
    private int $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;    
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = Order::find($this->id);
        
        //Поставим фиктивную задержку
        usleep(500);
            
        if($order){
            $order->status = "done";
            $order->save();
        }    
        //$this->id;
    }

}
