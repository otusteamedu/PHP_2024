<?php

namespace App\Http\Controllers\Court;

use App\Models\Court;

/**
 * @OA\Delete(
 *     path="/courts/{court}",
 *     summary="Удаление суда",
 *     description="Удаляет указанный суд по его ID.",
 *     operationId="deleteCourt",
 *     tags={"Courts"},
 *     @OA\Parameter(
 *         name="court",
 *         in="path",
 *         required=true,
 *         description="ID суда",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=302,
 *         description="Перенаправление на список судов"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Суд не найден"
 *     )
 * )
 */
class DestroyController extends BaseController
{
    public function __invoke(Court $court)
    {
        $court->delete();
        return redirect()->route('court.index');
    }
}
