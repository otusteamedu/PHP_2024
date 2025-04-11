<?php

namespace App\Http\Controllers\Court;

use App\Http\Filters\CourtFilter;
use App\Http\Requests\Court\IndexRequest;
use App\Models\Court;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/courts",
 *     summary="Получить список судов",
 *     tags={"Courts"},
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Номер страницы пагинации",
 *         required=false,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Parameter(
 *         name="name",
 *         in="query",
 *         description="Фильтр по названию суда",
 *         required=false,
 *         @OA\Schema(type="string", example="Кировского")
 *     ),
 *     @OA\Parameter(
 *         name="address",
 *         in="query",
 *         description="Фильтр по адресу суда",
 *         required=false,
 *         @OA\Schema(type="string", example="Хабаровск")
 *     ),
 *     @OA\Parameter(
 *         name="cass_region",
 *         in="query",
 *         description="Фильтр по региону кассации суда",
 *         required=false,
 *         @OA\Schema(type="string", example="1КО")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Список судов",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Court")
 *             ),
 *             @OA\Property(property="current_page", type="integer", example=1),
 *             @OA\Property(property="total", type="integer", example=100)
 *         )
 *     )
 * )
 */


class IndexController extends BaseController
{
    /**
     * Получение списка судов.
     *
     * @param IndexRequest $request
     * @return View|JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(CourtFilter::class, ['queryParams' => array_filter($data)]);

        $courts = Court::filter($filter)->paginate(10);

        return view("court.index", compact("courts"));
    }
}
