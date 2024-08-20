<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiatWithdraw extends Model
{
    use HasFactory;

    protected $table = 'fiat_withdraws';

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    protected $fillable = [
        'orderId',
        'coin',
        'amount',
        'txid',
        'status',
    ];

    public $timestamps = true;
}
