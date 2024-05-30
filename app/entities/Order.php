<?php


namespace App\entities;


class Order
{
    public $summary;
    public $order_list;

    /**
     * @return string
     */
    public function getSummary(): string
    {
        $this->calculateSummary();
        return $this->summary;
    }
    public function calculateSummary(){
        foreach ($this->order_list as $product => $value){
           $this->summary +=  $value["total_price"];
        }

    }
}