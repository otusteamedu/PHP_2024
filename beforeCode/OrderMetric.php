<?php

declare(strict_types=1);

namespace beforeCode;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Order\OrderMetric
 *
 * @property int $id
 * @property int $order_id
 * @property int $viewed_mail
 * @property int $viewed_page
 * @property int|null $rate
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMetric newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMetric newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMetric query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMetric whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMetric whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMetric whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMetric whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMetric whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMetric whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMetric whereViewedMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMetric whereViewedPage($value)
 * @property-read \App\Models\Order\Order|null $order
 * @mixin \Eloquent
 */
class OrderMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'viewed_mail',
        'viewed_page',
        'rate',
        'comment'
    ];

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
