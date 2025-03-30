<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Court",
 *     title="Court",
 *     description="Модель суда",
 *     @OA\Property(property="id", type="uuid", example="004cc1b9-997c-4028-8d0e-4f53a6acfa1f"),
 *     @OA\Property(property="name", type="string", example="Приокский районный суд г. Нижний Новгород (Нижегородская область)"),
 *     @OA\Property(property="address", type="string", example="119618, Москва, ул. 50-лет Октября, д. 6, корпус 2"),
 *     @OA\Property(property="region_id", type="string", example="1"),
 *     @OA\Property(property="cass_region", type="string", example="Московская область"),
 *     @OA\Property(property="general_type_id", type="string", example="1"),
 *     @OA\Property(property="phone", type="string", example="+7 495 123-45-67"),
 *     @OA\Property(property="email", type="string", example="info@court.ru"),
 *     @OA\Property(property="site", type="string", example="http://court.ru"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class Court extends Model
{
    /** @use HasFactory<\Database\Factories\CourtFactory> */
    use HasFactory;
    use Filterable;
    use SoftDeletes;

    protected $guarded = [];
    protected $keyType = 'string'; // Убедитесь, что это строка
    public $incrementing = false; // Отключаем автоинкремент для UUID

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }
}
