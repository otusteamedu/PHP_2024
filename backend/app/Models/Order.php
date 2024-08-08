<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'status',
        'cur_from',
        'cur_to',
        'amount_from',
        'amount_to',
        'rateFrom',
        'rateTo',
        'email',
        'recipient_account',
        'incoming_asset'
    ];
}
