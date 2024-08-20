<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $table = 'balances';

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    protected $fillable = [
        'cur_code',
        'balance'
    ];
}
