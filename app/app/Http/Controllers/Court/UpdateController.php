<?php

namespace App\Http\Controllers\Court;

use App\Http\Requests\Court\UpdateRequest;
use App\Models\Court;
use OpenApi\Annotations as OA;

/**
 * @OA\Put(
 *     path="/courts/{id}",
 *     summary="Обновить информацию о суде",
 *     tags={"Courts"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID суда",
 *         @OA\Schema(type="string", format="uuid")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UpdateCourtRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Суд успешно обновлён",
 *         @OA\JsonContent(ref="#/components/schemas/Court")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Ошибка в запросе"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Суд не найден"
 *     )
 * )
 */

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Court $court)
    {
        $data = $request->validated();

        $this->service->update($court, $data);

        return redirect()->route('court.show', $court->id);
    }
}
