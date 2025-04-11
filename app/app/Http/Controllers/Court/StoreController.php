<?php

namespace App\Http\Controllers\Court;

use App\Http\Requests\Court\StoreRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/courts",
 *     summary="Создать новый суд",
 *     tags={"Courts"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name", "address", "region_id", "cass_region", "general_type_id", "phone", "email", "site"},
 *             @OA\Property(property="name", type="string", example="Московский городской суд"),
 *             @OA\Property(property="address", type="string", example="Москва, ул. Тверская, 1"),
 *             @OA\Property(property="region_id", type="string", example="1"),
 *             @OA\Property(property="cass_region", type="string", example="Московская область"),
 *             @OA\Property(property="general_type_id", type="string", example="1"),
 *             @OA\Property(property="phone", type="string", example="+7 495 123-45-67"),
 *             @OA\Property(property="email", type="string", example="info@court.ru"),
 *             @OA\Property(property="site", type="string", example="http://court.ru")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Суд успешно создан",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Суд успешно создан")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Ошибки валидации данных",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Ошибка валидации данных")
 *         )
 *     )
 * )
 */
class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return redirect()->route('court.index');
    }
}
